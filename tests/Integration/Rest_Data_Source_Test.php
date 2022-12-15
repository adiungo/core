<?php

namespace Adiungo\Core\Tests\Integration;

use Adiungo\Core\Collections\Content_Model_Collection;
use Adiungo\Core\Factories\Data_Sources\Rest;
use Adiungo\Core\Tests\Integration\Mocks\Batch_Request_Builder;
use Adiungo\Core\Tests\Integration\Mocks\Batch_Response_Adapter_Mock;
use Adiungo\Core\Tests\Integration\Mocks\Has_More_Strategy_Mock;
use Adiungo\Core\Tests\Integration\Mocks\Http_Strategy_Mock;
use Adiungo\Core\Tests\Integration\Mocks\Single_Request_Builder;
use Adiungo\Core\Tests\Integration\Mocks\Test_Data_Source_Adapter;
use Adiungo\Core\Tests\Integration\Mocks\Test_Model;
use Adiungo\Tests\Test_Case;
use JsonException;
use Underpin\Enums\Rest as Method;
use Underpin\Enums\Types;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Url_Exception;
use Underpin\Exceptions\Validation_Failed;
use Underpin\Factories\Registry_Items\Param;
use Underpin\Factories\Request;
use Underpin\Factories\Url;

class Rest_Data_Source_Test extends Test_Case
{

    protected Rest $instance;

    public function setUp(): void
    {
        parent::setUp();

        $this->instance = (new Rest())
            ->set_data_source_adapter(new Test_Data_Source_Adapter())
            ->set_batch_request_builder(new Batch_Request_Builder())
            ->set_content_model_instance(Test_Model::class)
            ->set_has_more_strategy(new Has_More_Strategy_Mock())
            ->set_http_strategy(new Http_Strategy_Mock())
            ->set_single_request_builder(new Single_Request_Builder())
            ->set_batch_response_adapter(new Batch_Response_Adapter_Mock());

    }

    /**
     * @return void
     * @throws Operation_Failed
     * @throws Url_Exception
     * @throws Validation_Failed
     * @covers \Adiungo\Core\Factories\Data_Sources\Rest::get_data()
     */
    public function test_can_get_data(): void
    {
        $request = (new Request())
            ->set_url(Url::from('https://example.org/batch'))
            ->set_method(Method::Get)
            ->set_param((new Param('page', Types::Integer))->set_value(1));

        $this->instance->get_batch_request_builder()->set_request($request);

        $this->assertEquals((new Content_Model_Collection())->seed([
            $this->build_model(1),
            $this->build_model(2),
            $this->build_model(3),
            $this->build_model(4),
            $this->build_model(5),

        ]), $this->instance->get_data());
    }

    /**
     * Constructs a test model based on the provided ID.
     * @param int $id
     * @return Test_Model
     */
    protected function build_model(int $id): Test_Model
    {
        return (new Test_Model())
            ->set_id($id)
            ->set_content("This is item $id content")
            ->set_name("This is item $id");
    }

    /**
     * @return void
     * @throws Operation_Failed
     * @throws Url_Exception
     * @throws Validation_Failed
     * @throws JsonException
     * @covers \Adiungo\Core\Factories\Data_Sources\Rest::get_item()
     */
    public function test_can_get_item(): void
    {
        $request = (new Request())
            ->set_url(Url::from('https://example.org/single'))
            ->set_method(Method::Get)
            ->set_param((new Param('page', Types::Integer))->set_value(1));

        $this->instance->get_single_request_builder()->set_request($request);

        $this->assertEquals(
            $this->build_model(5),
            $this->instance->get_item(5)
        );
    }

    /**
     * @return void
     * @throws Operation_Failed
     * @throws Url_Exception
     * @throws Validation_Failed
     * @covers \Adiungo\Core\Factories\Data_Sources\Rest::get_next()
     */
    public function test_can_get_next(): void
    {
        $request = (new Request())
            ->set_url(Url::from('https://example.org/batch'))
            ->set_method(Method::Get)
            ->set_param((new Param('page', Types::Integer))->set_value(1));

        $this->instance->get_batch_request_builder()->set_request($request);

        $this->assertEquals((new Content_Model_Collection())->seed([
            $this->build_model(6),
            $this->build_model(7),
            $this->build_model(8),
            $this->build_model(9),
            $this->build_model(10),

        ]), $this->instance->get_next()->get_data());
    }

    /**
     * @return void
     * @throws Operation_Failed
     * @throws Url_Exception
     * @throws Validation_Failed
     * @covers \Adiungo\Core\Factories\Data_Sources\Rest::has_more()
     */
    public function test_can_loop(): void
    {
        $request = (new Request())
            ->set_url(Url::from('https://example.org/batch'))
            ->set_method(Method::Get)
            ->set_param((new Param('page', Types::Integer))->set_value(1));

        $this->instance->get_batch_request_builder()->set_request($request);

        $result = $this->instance->get_data()->to_array();
        while ($this->instance->has_more()) {
            $this->instance = $this->instance->get_next();
            $result = array_merge($result, $this->instance->get_data()->to_array());
        }

        $expected = [
            $this->build_model(1),
            $this->build_model(2),
            $this->build_model(3),
            $this->build_model(4),
            $this->build_model(5),
            $this->build_model(6),
            $this->build_model(7),
            $this->build_model(8),
            $this->build_model(9),
            $this->build_model(10),
        ];

        $this->assertEquals($expected, $result);
    }
}