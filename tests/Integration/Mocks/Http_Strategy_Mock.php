<?php

namespace Adiungo\Core\Tests\Integration\Mocks;

use Adiungo\Core\Abstracts\Http_Strategy;
use Underpin\Helpers\String_Helper;

class Http_Strategy_Mock extends Http_Strategy
{

    public function __toString(): string
    {
        return $this->to_string();
    }

    public function to_string(): string
    {
        if (String_Helper::ends_with((string)$this->get_request()->get_url()->get_path(), 'batch')) {
            $page = $this->get_request()->get_param('page')->get_value();
            $file = 'batch-response-' . $page . '.json';
        } else {
            $file = 'single-response.json';
        }

        return (string)file_get_contents(String_Helper::append(__DIR__, '/') . $file);
    }
}