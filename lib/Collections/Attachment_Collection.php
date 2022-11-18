<?php

namespace Adiungo\Core\Collections;


use Adiungo\Core\Interfaces\Attachment;
use Underpin\Abstracts\Registries\Object_Registry;

class Attachment_Collection extends Object_Registry
{
    protected string $abstraction_class = Attachment::class;
}