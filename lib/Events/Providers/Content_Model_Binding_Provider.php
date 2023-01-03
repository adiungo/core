<?php

namespace Adiungo\Core\Events\Providers;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Collections\Content_Model_Collection;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Interfaces\Data_Provider;

class Content_Model_Binding_Provider implements Data_Provider
{
    protected Content_Model_Collection $models;

    /**
     * @param Content_Model $model_a The first model to bind. Note the order of these arguments does not matter.
     * @param Content_Model $model_b The other model to bind. Note the order of these arguments does not matter.
     */
    public function __construct(Content_Model $model_a, Content_Model $model_b)
    {
        try {
            $this->models = (new Content_Model_Collection())->seed([$model_a, $model_b]);
        }catch (Operation_Failed $exception){
        }
    }

    /**
     * Fetches the models in this provider.
     *
     * @return Content_Model_Collection
     */
    public function get_models(): Content_Model_Collection
    {
        return $this->models;
    }
}