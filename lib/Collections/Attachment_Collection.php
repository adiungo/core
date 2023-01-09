<?php

namespace Adiungo\Core\Collections;

use Adiungo\Core\Abstracts\Attachment;

class Attachment_Collection extends Content_Model_Collection
{
    protected string $abstraction_class = Attachment::class;
}
