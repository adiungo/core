<?php

namespace Adiungo\Core\Tests\Unit\Factories\Data_Sources;

use Adiungo\Core\Abstracts\Batch_Response_Adapter;
use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Abstracts\Has_More_Strategy;
use Adiungo\Core\Abstracts\Http_Strategy;
use Adiungo\Core\Abstracts\Int_Id_Based_Request_Builder;
use Adiungo\Core\Abstracts\Single_Response_Adapter;
use Adiungo\Core\Collections\Content_Model_Collection;
use Adiungo\Core\Factories\Data_Sources\Rest;
use Adiungo\Core\Interfaces\Has_Paginated_Request;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Inaccessible_Methods;
use Adiungo\Tests\Traits\With_Inaccessible_Properties;
use Generator;
use Mockery;
use ReflectionException;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Factories\Request;

class Rest_Test extends Test_Case
{
    use With_Inaccessible_Properties;
    use With_Inaccessible_Methods;

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\Rest::get_response
     * @return void
     * @throws ReflectionException
     */
    public function test_can_get_response(): void
    {
        $instance = Mockery::mock(Rest::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $strategy = Mockery::mock(Http_Strategy::class);
        $request = Mockery::mock(Request::class);

        $strategy->allows('to_string')->andReturn('{"foo":"bar"}');
        $strategy->expects('set_request')->with($request);
        $instance->allows('get_http_strategy')->andReturn($strategy);

        $result = $this->call_inaccessible_method($instance, 'get_response', $request);

        $this->assertEquals('{"foo":"bar"}', $result);
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\Rest::get_data
     * @return void
     */
    public function test_can_get_data(): void
    {
        $instance = Mockery::mock(Rest::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $request = Mockery::mock(Request::class);
        $response = '{"foo": "bar"}';
        $adapter = Mockery::mock(Batch_Response_Adapter::class);
        $expected = ['foo' => 'foo', 'bar' => 'bar'];

        $instance->expects('get_batch_request_builder->get_request')->andReturn($request);
        $instance->expects('get_response')->with($request)->andReturn($response);
        $instance->expects('get_batch_response_adapter')->andReturn($adapter);
        $instance->allows('get_data_source_adapter->convert_to_model')->andReturnUsing(function (array $data) {
            $result = Mockery::mock(Content_Model::class);
            $result->allows('get_id')->andReturn($data[0]);

            return $result;
        });

        $adapter->expects('set_response')->with($response);
        $adapter->expects('to_array')->andReturn([['foo'], ['bar']]);

        $items = $instance->get_data()->pluck('id');

        $this->assertEquals($expected, $items);
    }

    /**
     * @covers       \Adiungo\Core\Factories\Data_Sources\Rest::has_more
     * @param bool $expected
     * @param string[] $cache
     * @param bool $has_more
     * @return void
     * @throws ReflectionException
     * @dataProvider provider_has_more
     */
    public function test_has_more(bool $expected, array $cache, bool $has_more): void
    {
        $instance = Mockery::mock(Rest::class)->makePartial();
        $collection = new Content_Model_Collection();
        $strategy = Mockery::namedMock('Has_More_Mock', Has_More_Strategy::class);

        $this->set_protected_property($instance, 'object_cache', $cache);

        $instance->allows('get_data')->andReturn($collection);
        $instance->allows('get_has_more_strategy')->andReturn($strategy);

        $strategy->allows('set_content_model_collection')->with($collection)->andReturn($strategy);

        $strategy->expects('has_more')->times((int)!empty($cache))->andReturn($has_more);

        $this->assertEquals($expected, $instance->has_more());
    }

    protected function provider_has_more(): Generator
    {
        yield 'Returns true when data has not been fetched' => [true, [], false];
        yield 'Returns false when strategy returns false and data has been fetched' => [false, ['get_data' => 'foo'], false];
        yield 'Returns true when strategy returns true and data has been fetched' => [true, ['get_data' => 'foo'], true];
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\Rest::get_next
     * @return void
     * @throws ReflectionException
     */
    public function test_can_get_next(): void
    {
        $next_builder = Mockery::mock(Has_Paginated_Request::class);
        $builder = Mockery::mock(Has_Paginated_Request::class);
        $instance = (new Rest())->set_batch_request_builder($builder);

        $this->set_protected_property($instance, 'object_cache', ['foo' => 'bar']);

        $builder->allows('get_next')->andReturn($next_builder);

        $expected = $instance->get_next();

        $this->assertEquals([], $this->get_protected_property($expected, 'object_cache')->getValue($expected));
        $this->assertSame($expected->get_batch_request_builder(), $next_builder);
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\Rest::get_item
     * @return void
     * @throws Operation_Failed
     */
    public function test_can_get_item(): void
    {
        $instance = Mockery::mock(Rest::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $request = Mockery::mock(Request::class);
        $response = '{"foo": "bar"}';
        $builder = Mockery::mock(Int_Id_Based_Request_Builder::class);
        $expected = Mockery::mock(Content_Model::class);
        $adapter = Mockery::mock(Single_Response_Adapter::class);

        $adapter->expects('set_response')->with($response);
        $adapter->expects('to_array')->once()->andReturn([['foo' => 'bar']]);

        $builder->expects('set_id')->once()->andReturn($builder);
        $builder->expects('get_request')->once()->andReturn($request);

        $instance->expects('get_single_request_builder')->once()->andReturn($builder);
        $instance->expects('get_response')->with($request)->once()->andReturn($response);
        $instance->expects('get_data_source_adapter->convert_to_model')->once()->andReturn($expected);
        $instance->expects('get_single_response_adapter')->andReturn($adapter);

        $this->assertSame($instance->get_item(123), $expected);
        // Run twice to confirm the data is cached and does not run more than once.
        $this->assertSame($instance->get_item(123), $expected);
    }
}
