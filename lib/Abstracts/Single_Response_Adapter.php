<?php

namespace Adiungo\Core\Abstracts;

use Adiungo\Core\Interfaces\Has_Response;
use Adiungo\Core\Traits\With_Response;
use Underpin\Interfaces\Can_Convert_To_Array;

abstract class Single_Response_Adapter implements Can_Convert_To_Array, Has_Response
{
    use With_Response;
}