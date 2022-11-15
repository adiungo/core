<?php

namespace Adiungo\Core\Abstracts;


use Adiungo\Core\Interfaces\Has_Index_Strategy;
use Adiungo\Core\Traits\With_Index_Strategy;

abstract class Index_Strategy_Builder implements Has_Index_Strategy
{
    use With_Index_Strategy;

    abstract protected function get_model(): string;
}