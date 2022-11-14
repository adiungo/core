<?php

namespace Adiungo\Core\Abstracts;


use Underpin\Interfaces\Identifiable;
use Underpin\Interfaces\Model;

abstract class Content_Model implements Model, Identifiable
{
    /**
     * Saves this model.
     *
     * @return $this
     */
    public function save(): static
    {
        //TODO: IMPLEMENT THIS METHOD.
        return $this;
    }

    /**
     * Delete this model.
     *
     * @return $this
     */
    public function delete(): static
    {
        //TODO: IMPLEMENT THIS METHOD.
        return $this;
    }
}