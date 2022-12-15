<?php

namespace Adiungo\Core\Tests\Integration\Mocks;


use Adiungo\Core\Interfaces\Has_Paginated_Request;
use Underpin\Enums\Types;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Unknown_Registry_Item;
use Underpin\Exceptions\Validation_Failed;
use Underpin\Factories\Registry_Items\Param;
use Underpin\Traits\With_Request;

final class Batch_Request_Builder implements Has_Paginated_Request
{
    use With_Request;

    /**
     * @throws Validation_Failed
     * @throws Operation_Failed|Unknown_Registry_Item
     */
    public function get_next(): static
    {
        $page = (new Param('page', Types::Integer))->set_value($this->get_request()->get_param('page')->get_value() + 1);
        $request = clone $this->get_request();
        $request->get_url()->get_params()->remove('page');
        $request->set_param($page);

        return (new Batch_Request_Builder())->set_request($request);
    }
}