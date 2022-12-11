<?php

namespace Adiungo\Core\Factories\Data_Sources;


use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Collections\Content_Model_Collection;
use Adiungo\Core\Interfaces\Data_Source;
use Adiungo\Core\Interfaces\Has_Batch_Request_Builder;
use Adiungo\Core\Interfaces\Has_Content_Model_Instance;
use Adiungo\Core\Interfaces\Has_Data_Source_Adapter;
use Adiungo\Core\Interfaces\Has_Has_More_Strategy;
use Adiungo\Core\Interfaces\Has_Single_Request_Builder;
use Adiungo\Core\Traits\With_Batch_Request_Builder;
use Adiungo\Core\Traits\With_Content_Model_Instance;
use Adiungo\Core\Traits\With_Data_Source_Adapter;
use Adiungo\Core\Traits\With_Has_More_Strategy;
use Adiungo\Core\Traits\With_Single_Request_Builder;
use JsonException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Factories\Request;
use Underpin\Helpers\Array_Helper;
use Underpin\Traits\With_Object_Cache;

class Rest implements Data_Source, Has_Content_Model_Instance, Has_Data_Source_Adapter, Has_Has_More_Strategy, Has_Batch_Request_Builder, Has_Single_Request_Builder
{
    use With_Content_Model_Instance;
    use With_Data_Source_Adapter;
    use With_Object_Cache;
    use With_Has_More_Strategy;
    use With_Single_Request_Builder;
    use With_Batch_Request_Builder;

    public function get_data(): Content_Model_Collection
    {
        // TODO: Implement get_data() method.
        return new Content_Model_Collection();
    }

    public function has_more(): bool
    {
        // TODO: Implement has_more() method.
        return false;
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
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Operation_Failed
     * @throws JsonException
     */
    public function get_item(int|string $id): Content_Model
    {
        return $this->load_from_cache('get_item', function () use ($id) {
            $instance = $this->get_single_request_builder()->set_id($id)->get_request();

            $data = Array_Helper::wrap(json_decode($this->make_request($instance)->getContent(), true, 512, JSON_THROW_ON_ERROR));

            return $this->get_data_source_adapter()->convert_to_model($data);
        });
    }

    /**
     * @throws TransportExceptionInterface
     */
    protected function make_request(Request $request): ResponseInterface
    {
        return HttpClient::create()->request('', '');
    }
}