<?php

namespace Adiungo\Core\Traits;

trait With_Remote_Id
{
    protected int $remote_id;

    /**
     * Sets the remote ID
     *
     * @param int $id
     * @return $this
     */
    public function set_remote_id(int $id): static
    {
        $this->remote_id = $id;

        return $this;
    }

    /**
     * Gets the remote ID
     *
     * @return int
     */
    public function get_remote_id(): int
    {
        return $this->remote_id;
    }
}
