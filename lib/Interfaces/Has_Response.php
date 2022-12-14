<?php

namespace Adiungo\Core\Interfaces;


use Symfony\Contracts\HttpClient\ResponseInterface;

interface Has_Response
{
    /**
     * Gets the data source
     * @return ResponseInterface
     */
    public function get_response(): ResponseInterface;

    /**
     * Sets the data source
     * @param ResponseInterface $response
     * @return $this
     */
    public function set_response(ResponseInterface $response): static;
}