<?php

namespace Adiungo\Core\Tests\Unit\Factories\Adapters;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Factories\Adapters\Data_Source_Adapter;
use Adiungo\Core\Tests\Integration\Mocks\Test_Model;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Inaccessible_Methods;
use Closure;
use Generator;
use Mockery;
use ReflectionException;
use Underpin\Enums\Types;
use Underpin\Exceptions\Item_Not_Found;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Factories\Registry;

class Data_Source_Adapter_Test extends Test_Case
{
    use With_Inaccessible_Methods;

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\CSV::convert_to_model
     *
     * @throws ReflectionException
     * @throws Operation_Failed
     */
    public function test_can_convert_to_model(): void
    {
        $instance = Mockery::mock(Data_Source_Adapter::class)->shouldAllowMockingProtectedMethods()->makePartial();

        Mockery::namedMock('Test_Mock', Content_Model::class);

        $items = [
            'foo' => ['type' => Types::String, 'setter' => 'baz'],
            'foofoo' => ['type' => Types::String, 'setter' => 'bazbaz'],
        ];

        $raw = ['foo' => 'bar', 'foofoo' => 'barbar'];

        $instance->expects('set_mapped_property')->times(count($items));
        $instance->allows('get_content_model_instance')->andReturn('Test_Mock');
        $instance->allows('get_mappings')->andReturn((new Registry(fn () => true))->seed($items));
        $this->call_inaccessible_method($instance, 'convert_to_model', $raw);
    }

    /**
     * @covers       \Adiungo\Core\Factories\Data_Sources\CSV::set_mapped_property()
     *
     * @param mixed $expected
     * @param mixed[] $raw_model
     * @param string $setter
     * @param Types|Closure $type
     * @param string $key
     * @throws ReflectionException
     * @dataProvider provider_set_mapped_property
     */
    public function test_can_set_mapped_property(mixed $expected, array $raw_model, string $setter, Types|Closure $type, string $key): void
    {
        $source = Mockery::mock(Data_Source_Adapter::class)->shouldAllowMockingProtectedMethods()->makePartial();

        $model = Mockery::mock(Content_Model::class);
        $model->expects($setter)->with($expected)->andReturn($model);

        $this->call_inaccessible_method($source, 'set_mapped_property', $key, $type, $setter, $raw_model, $model);
    }

    public function provider_set_mapped_property(): Generator
    {
        yield 'it converts types' => [6, ['key' => '6'], 'set_int', Types::Integer, 'key'];
        yield 'it sets values' => ['alex', ['key' => 'alex'], 'set_name', Types::String, 'key'];
        yield 'it sets dotted values' => [6, ['key' => ['subkey' => ['int' => 6]]], 'set_name', Types::Integer, 'key.subkey.int'];
        yield 'it converts types with closures' => [1000, ['key' => '6'], 'set_int', fn () => 1000, 'key'];
        yield 'it sets values with closures' => ['Alex', ['key' => 'alex'], 'set_name', fn () => 'Alex', 'key'];
        yield 'it sets dotted values with closures' => ['AleX', ['key' => ['subkey' => 'alex']], 'set_name', fn () => 'AleX', 'key.subkey'];
    }

    /**
     * @covers       \Adiungo\Core\Factories\Data_Sources\CSV::mapping_is_valid
     *
     * @throws ReflectionException
     * @dataProvider provider_mapping_is_valid
     */
    public function test_mapping_is_valid(bool $expected, string $setter, Types|Closure $type): void
    {
        $mock = new class () extends Content_Model {
            public function get_id(): string|int|null
            {
                return 123;
            }

            public function set_test_value(): void
            {
                return;
            }
        };

        $instance = Mockery::mock(Data_Source_Adapter::class);
        $instance->allows('get_content_model_instance')->andReturn($mock::class);

        $this->assertSame($expected, $this->call_inaccessible_method($instance, 'mapping_is_valid', $setter, $type));
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\CSV::get_mappings
     * @throws ReflectionException
     */
    public function test_can_get_mappings(): void
    {
        $source = new Data_Source_Adapter();
        $item = $this->call_inaccessible_method($source, 'get_mappings');
        $item_again = $this->call_inaccessible_method($source, 'get_mappings');

        $this->assertSame($item, $item_again);
        $this->assertInstanceOf(Registry::class, $item);
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\CSV::map_field
     * @return void
     * @throws Operation_Failed
     */
    public function test_map_field_catches_thrown_exceptions(): void
    {
        $instance = Mockery::mock(Data_Source_Adapter::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $column = 'foo';
        $instance->allows('get_content_model_instance')->andReturn('Mocked_Model');
        $setter = 'bar';
        $type = Types::String;
        $instance->expects('get_mappings->add')->with($column, ['setter' => $setter, 'type' => $type])->andThrow(Operation_Failed::class);

        $this->expectException(Operation_Failed::class);
        $this->expectExceptionMessage("Column mapping failed - The $setter method cannot be found on the Mocked_Model model.");

        $instance->map_field($column, $setter, $type);
    }

    /**
     * @covers       \Adiungo\Core\Factories\Data_Sources\CSV::map_field
     * @param Types|Closure $type
     * @return void
     * @throws Operation_Failed
     * @dataProvider provider_map_field
     */
    public function test_can_map_field(Types|Closure $type): void
    {
        $instance = Mockery::mock(Data_Source_Adapter::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $column = 'foo';
        $setter = 'bar';
        $instance->expects('get_mappings->add')->with($column, ['setter' => $setter, 'type' => $type]);

        $this->assertSame($instance, $instance->map_field($column, $setter, $type));
    }

    /** @see test_can_map_field */
    public function provider_map_field(): Generator
    {
        yield 'supports closure' => [fn () => 'test'];
        yield 'supports type' => [Types::String];
    }

    /** @see test_mapping_is_valid */
    protected function provider_mapping_is_valid(): Generator
    {
        yield 'valid setter returns true with Type' => [true, 'set_test_value', Types::String];
        yield 'valid setter returns false with Type and invalid setter.' => [false, 'invalid', Types::String];
        yield 'invalid setter returns true with closure' => [true, 'set_test_value', fn () => 'foo'];
        yield 'invalid setter returns false with closure and invalid setter.' => [false, 'invalid', fn () => 'foo'];
    }
}
