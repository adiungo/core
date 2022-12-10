<?php

namespace Adiungo\Core\Abstracts;


use Underpin\Interfaces\Has_Request;
use Underpin\Interfaces\Identifiable_Int;
use Underpin\Traits\With_Request;

abstract class Int_Id_Based_Request_Builder implements Identifiable_Int, Has_Request
{
    use With_Request;
}