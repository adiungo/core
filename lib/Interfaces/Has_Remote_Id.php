<?php

namespace Adiungo\Core\Interfaces;

interface Has_Remote_Id
{
    /**
     * Gets the remote ID
     *
     * @return int
     */
    public function get_remote_id(): int;

    /**
     * Sets the remote ID
     *
     * @param int $id
     * @return $this
     */
    public function set_remote_id(int $id): static;
}
