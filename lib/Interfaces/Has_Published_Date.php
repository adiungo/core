<?php

namespace Adiungo\Core\Interfaces;

use DateTime;

interface Has_Published_Date
{

    /**
     * Gets the published date
     *
     * @return DateTime
     */
    public function get_published_date(): DateTime;

    /**
     * Sets the published date
     *
     * @param DateTime $published_date The published_date to set.
     * @return $this
     */
    public function set_published_date(DateTime $published_date): static;
}