<?php

namespace Adiungo\Core\Interfaces;

use DateTime;

interface Has_Last_Requested_Date
{
    /**
     * Gets the last requested date
     *
     * @return DateTime
     */
    public function get_last_requested_date(): DateTime;

    /**
     * Sets the last requested date
     *
     * @param DateTime $last_requested_date The last requested_date to set.
     * @return $this
     */
    public function set_last_requested_date(DateTime $last_requested_date): static;
}
