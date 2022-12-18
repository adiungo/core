<?php

namespace Adiungo\Core\Abstracts;

use Underpin\Interfaces\Can_Convert_To_String;
use Underpin\Interfaces\Has_Request;
use Underpin\Traits\With_Request;

abstract class Http_Strategy implements Can_Convert_To_String, Has_Request
{
    use With_Request;
}
