<?php

namespace Adiungo\Core\Collections;


use Adiungo\Core\Abstracts\Content_Model;
use Underpin\Abstracts\Registries\Object_Registry;

class Content_Model_Collection extends Object_Registry
{
    protected string $abstraction_class = Content_Model::class;
}