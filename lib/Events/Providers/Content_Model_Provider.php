<?php

namespace Adiungo\Core\Events\Providers;

use Adiungo\Core\Abstracts\Content_Model;
use Underpin\Interfaces\Data_Provider;

class Content_Model_Provider implements Data_Provider
{
    /**
     * Constructor.
     *
     * @param Content_Model $content_model
     */
    public function __construct(protected Content_Model $content_model)
    {
    }

    /**
     * Gets the content model provided by this class.
     *
     * @return Content_Model
     */
    public function get_model(): Content_Model
    {
        return $this->content_model;
    }
}
