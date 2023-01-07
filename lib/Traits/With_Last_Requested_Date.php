<?php

namespace Adiungo\Core\Traits;

namespace Adiungo\Core\Traits;

use DateTime;

trait With_Last_Requested_Date
{
    protected DateTime $last_requested_date;

    /**
     * Gets the last requested date
     *
     * @return DateTime
     */
    public function get_last_requested_date(): DateTime
    {
        return $this->last_requested_date;
    }

    /**
     * Sets the last requested date
     *
     * @param DateTime $last_requested_date The last_date to set.
     * @return $this
     */
    public function set_last_requested_date(DateTime $last_requested_date): static
    {
        $this->last_requested_date = $last_requested_date;

        return $this;
    }
}
