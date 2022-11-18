<?php

namespace Adiungo\Core\Collections;

use Adiungo\Core\Factories\Category;
use Underpin\Abstracts\Registries\Object_Registry;

class Category_Collection extends Object_Registry
{
    protected string $abstraction_class = Category::class;
}