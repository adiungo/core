<?php

namespace Adiungo\Core\Tests\Integration\Mocks;

use Adiungo\Core\Abstracts\Int_Id_Based_Request_Builder;
use Underpin\Enums\Types;
use Underpin\Factories\Registry_Items\Param;

class Single_Request_Builder extends Int_Id_Based_Request_Builder
{
    public function get_id(): ?int
    {
        $value = $this->get_request()->get_param('id')->get_value();
        return is_int($value) ? $value : null;
    }

    public function set_id(?int $id): static
    {
        $this->get_request()->set_param((new Param('id', Types::Integer))->set_value($id));

        return $this;
    }
}
