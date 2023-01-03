<?php

namespace Adiungo\Core\Factories\Attachments;

use Adiungo\Core\Abstracts\Attachment;
use Adiungo\Core\Traits\With_Origin;
use Underpin\Traits\With_String_Identity;

class Video extends Attachment
{
    use With_String_Identity;
    use With_Origin;
}
