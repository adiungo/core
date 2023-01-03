<?php

namespace Adiungo\Core\Abstracts;

use Adiungo\Core\Interfaces\Has_Origin;
use Adiungo\Core\Traits\With_Origin;
use Underpin\Interfaces\Identifiable_String;
use Underpin\Traits\With_String_Identity;

abstract class Attachment extends Content_Model implements Has_Origin, Identifiable_String
{
    use With_String_Identity;
    use With_Origin;
}