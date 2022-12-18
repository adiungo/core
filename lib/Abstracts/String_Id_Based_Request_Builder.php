<?php

namespace Adiungo\Core\Abstracts;

use Underpin\Interfaces\Has_Request;
use Underpin\Interfaces\Identifiable_String;
use Underpin\Traits\With_Request;

abstract class String_Id_Based_Request_Builder implements Identifiable_String, Has_Request
{
    use With_Request;
}
