<?php

namespace Adiungo\Core\Factories;


use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Interfaces\Has_Data_Source;
use Adiungo\Core\Traits\With_Data_Source;

class Index_Strategy implements Has_Data_Source
{
    use With_Data_Source;

    public function __construct(protected string $model)
    {

    }

    /**
     * Saves the model.
     *
     * @param Content_Model $model
     * @return void
     */
    protected function save_item(Content_Model $model): void
    {
        $model->save();
    }

    /**
     * Fetches data and saves the found content.
     *
     * @return void
     */
    public function index_data(): void
    {
        $this->get_data_source()->get_data()->each([$this, 'save_item']);
    }
}