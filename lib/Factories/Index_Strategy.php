<?php

namespace Adiungo\Core\Factories;


use Adiungo\Core\Interfaces\Has_Data_Source;
use Adiungo\Core\Traits\With_Data_Source;

class Index_Strategy implements Has_Data_Source
{
    use With_Data_Source;

    public function __construct(protected string $model)
    {

    }

    public function index_data(): void
    {
        //TODO: IMPLEMENT INDEX DATA.
    }
}