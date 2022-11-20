<?php

namespace Adiungo\Core\Factories\Attachments;


use Adiungo\Core\Interfaces\Attachment;
use Adiungo\Core\Traits\With_Origin;
use Underpin\Traits\With_String_Identity;

class Audio implements Attachment
{
    use With_String_Identity;
    use With_Origin;
}