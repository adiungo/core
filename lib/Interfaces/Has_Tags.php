<?php

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Collections\Tag_Collection;
use Adiungo\Core\Factories\Tag;
use Underpin\Exceptions\Operation_Failed;

interface Has_Tags
{
    /**
     * Gets the tag collection
     *
     * @return Tag_Collection
     */
    public function get_tags(): Tag_Collection;

    /**
     * Adds tags to the collection.
     *
     * @param Tag $tag
     * @param Tag ...$tags
     * @return $this
     * @throws Operation_Failed
     */
    public function add_tags(Tag $tag, Tag ...$tags): static;

    /**
     * Removes the specified tags, if they exist. Ignores any ID that does not exist.
     *
     * @param string $id
     * @param string ...$ids
     * @return $this
     * @throws Operation_Failed
     */
    public function remove_tags(string $id, string ...$ids): static;

    /**
     * @param string $content
     * @param string ...$more_content
     * @return $this
     * @throws Operation_Failed
     */
    public function import_tags(string $content, string ...$more_content): static;

    /**
     * Returns true if this class has any categories.
     *
     * @return bool
     */
    public function has_tags(): bool;
}
