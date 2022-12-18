<?php

namespace Adiungo\Core\Traits;

namespace Adiungo\Core\Traits;

use DateTime;

trait With_Updated_Date
{
    protected DateTime $updated_date;

    /**
     * Gets the updated date
     *
     * @return DateTime
     */
    public function get_updated_date(): DateTime
    {
        return $this->updated_date;
    }

    /**
     * Sets the updated date
     *
     * @param DateTime $updated_date The updated_date to set.
     * @return $this
     */
    public function set_updated_date(DateTime $updated_date): static
    {
        $this->updated_date = $updated_date;

        return $this;
    }
}
