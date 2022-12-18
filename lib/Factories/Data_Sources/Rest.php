<?php

namespace Adiungo\Core\Factories\Data_Sources;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Collections\Content_Model_Collection;
use Adiungo\Core\Interfaces\Data_Source;
use Adiungo\Core\Interfaces\Has_Batch_Request_Builder;
use Adiungo\Core\Interfaces\Has_Batch_Response_Adapter;
use Adiungo\Core\Interfaces\Has_Content_Model_Instance;
use Adiungo\Core\Interfaces\Has_Data_Source_Adapter;
use Adiungo\Core\Interfaces\Has_Has_More_Strategy;
use Adiungo\Core\Interfaces\Has_Http_Strategy;
use Adiungo\Core\Interfaces\Has_Single_Request_Builder;
use Adiungo\Core\Interfaces\Has_Single_Response_Adapter;
use Adiungo\Core\Traits\With_Batch_Request_Builder;
use Adiungo\Core\Traits\With_Batch_Response_Adapter;
use Adiungo\Core\Traits\With_Content_Model_Instance;
use Adiungo\Core\Traits\With_Data_Source_Adapter;
use Adiungo\Core\Traits\With_Has_More_Strategy;
use Adiungo\Core\Traits\With_Http_Strategy;
use Adiungo\Core\Traits\With_Single_Request_Builder;
use Adiungo\Core\Traits\With_Single_Response_Adapter;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Factories\Request;
use Underpin\Helpers\Array_Helper;
use Underpin\Traits\With_Object_Cache;

class Rest implements Data_Source, Has_Content_Model_Instance, Has_Http_Strategy, Has_Data_Source_Adapter, Has_Batch_Response_Adapter, Has_Single_Response_Adapter, Has_Has_More_Strategy, Has_Batch_Request_Builder, Has_Single_Request_Builder
{
    use With_Content_Model_Instance;
    use With_Data_Source_Adapter;
    use With_Batch_Response_Adapter;
    use With_Object_Cache;
    use With_Has_More_Strategy;
    use With_Single_Request_Builder;
    use With_Batch_Request_Builder;
    use With_Http_Strategy;
    use With_Single_Response_Adapter;

    public function get_data(): Content_Model_Collection
    {
        return $this->load_from_cache('get_data', function () {
            $request = $this->get_batch_request_builder()->get_request();
            $response = $this->get_batch_response_adapter()->set_response($this->get_response($request))->to_array();

            return (new Content_Model_Collection())->seed(Array_Helper::each($response, function (array $data) {
                return $this->get_data_source_adapter()->convert_to_model($data);
            }));
        });
    }

    public function has_more(): bool
    {
        // If we haven't fetched data, there's definitely more to get.
        if (!isset($this->object_cache['get_data'])) {
            return true;
        }

        return $this->get_has_more_strategy()->set_content_model_collection($this->get_data())->has_more();
    }

    /**
     * Gets the Rest instance for the next batch of data.
     *
     * @return static
     */
    public function get_next(): static
    {
        $instance = clone $this;

        // Reset the object cache.
        $instance->object_cache = [];

        return $instance->set_batch_request_builder($this->get_batch_request_builder()->get_next());
    }

    /**
     * @param int|string $id
     * @return Content_Model
     * @throws Operation_Failed
     */
    public function get_item(int|string $id): Content_Model
    {
        return $this->load_from_cache('get_item', function () use ($id) {
            $request = $this->get_single_request_builder()->set_id($id)->get_request();

            $data = $this->get_single_response_adapter()->set_response($this->get_response($request))->to_array();

            return $this->get_data_source_adapter()->convert_to_model($data);
        });
    }

    /**
     * @param Request $request
     * @return string The response body.
     */
    protected function get_response(Request $request): string
    {
        return $this->get_http_strategy()->set_request($request)->to_string();
    }
}
