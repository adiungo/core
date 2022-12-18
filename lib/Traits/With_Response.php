<?php

namespace Adiungo\Core\Traits;

/**
 * @see Has_Response
 */
trait With_Response
{
    protected string $response;

    public function get_response(): string
    {
        return $this->response;
    }

    public function set_response(string $response): static
    {
        $this->response = $response;

        return $this;
    }
}
