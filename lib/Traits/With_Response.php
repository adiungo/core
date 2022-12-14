<?php

namespace Adiungo\Core\Traits;


namespace Adiungo\Core\Traits;

use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @see Has_ResponseInterface
 */
trait With_Response
{

    protected ResponseInterface $response;

    public function get_response(): ResponseInterface
    {
        return $this->response;
    }

    public function set_response(ResponseInterface $response): static
    {
        $this->response = $response;

        return $this;
    }

}