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
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Underpin\Factories\Request;
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

    public function get_next(): static
    {
        // TODO: Implement get_next() method.
        return clone $this;
    }

    public function get_item(int|string $id): Content_Model
    {
        // TODO: Implement get_item() method.
        return new class extends Content_Model {
            public function get_id(): string|int|null
            {
                return null;
            }
        };
    }

    /**
     * @throws TransportExceptionInterface
     */
    protected function make_request(Request $request): ResponseInterface
    {
        return HttpClient::create()->request('', '');
    }
}