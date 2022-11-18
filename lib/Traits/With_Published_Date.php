<?php

namespace Adiungo\Core\Traits;


namespace Adiungo\Core\Traits;

use DateTime;

trait With_Published_Date
{

    protected DateTime $published_date;

    /**
     * Gets the published date
     *
     * @return DateTime
     */
    public function get_published_date(): DateTime
    {
        return $this->published_date;
    }

    /**
     * Sets the published date
     *
     * @param DateTime $published_date The published_date to set.
     * @return $this
     */
    public function set_published_date(DateTime $published_date): static
    {
        $this->published_date = $published_date;

        return $this;
    }

}