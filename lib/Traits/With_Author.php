<?php

namespace Adiungo\Core\Traits;


namespace Adiungo\Core\Traits;

trait With_Author
{

    protected string $author;

    /**
     * Gets the author
     *
     * @return String
     */
    public function get_author(): string
    {
        return $this->author;
    }

    /**
     * Sets the author
     *
     * @param String $author The author to set.
     * @return $this
     */
    public function set_author(string $author): static
    {
        $this->author = $author;

        return $this;
    }

}