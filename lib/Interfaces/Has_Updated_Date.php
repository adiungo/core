<?php

namespace Adiungo\Core\Interfaces;

use DateTime;

interface Has_Updated_Date
{
    /**
     * Gets the updated date
     *
     * @return DateTime
     */
    public function get_updated_date(): DateTime;

    /**
     * Sets the updated date
     *
     * @param DateTime $updated_date The updated_date to set.
     * @return $this
     */
    public function set_updated_date(DateTime $updated_date): static;
}
