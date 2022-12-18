<?php

namespace Adiungo\Core\Traits;

namespace Adiungo\Core\Traits;

use Adiungo\Core\Collections\Tag_Collection;
use Adiungo\Core\Factories\Tag;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Helpers\Array_Helper;

trait With_Tags
{
    protected Tag_Collection $tags;

    /**
     * Adds tags to the collection.
     *
     * @param Tag $tag
     * @param Tag ...$tags
     * @return $this
     * @throws Operation_Failed
     */
    public function add_tags(Tag $tag, Tag ...$tags): static
    {
        Array_Helper::each(func_get_args(), fn (Tag $tag) => $this->get_tags()->add((string)$tag->get_id(), $tag));

        return $this;
    }

    /**
     * Gets the tag collection
     *
     * @return Tag_Collection
     */
    public function get_tags(): Tag_Collection
    {
        if (!isset($this->tags)) {
            $this->tags = new Tag_Collection();
        }

        return $this->tags;
    }

    /**
     * Removes the specified tags, if they exist. Ignores any ID that does not exist.
     *
     * @param string $id
     * @param string ...$ids
     * @return $this
     * @throws Operation_Failed
     */
    public function remove_tags(string $id, string ...$ids): static
    {
        /** @var Tag_Collection $tags */
        $tags = $this->get_tags()->query()->key_not_in(...func_get_args())->get_results();
        $this->tags = $tags;

        return $this;
    }

    /**
     * @param string $content
     * @param string ...$more_content
     * @return $this
     * @throws Operation_Failed
     */
    public function import_tags(string $content, string ...$more_content): static
    {
        Array_Helper::each(func_get_args(), fn (string $content) => $this->get_tags()->from_string($content));

        return $this;
    }

    /**
     * Returns true if this class has any tags.
     *
     * @return bool
     */
    public function has_tags(): bool
    {
        return !empty($this->get_tags()->to_array());
    }
}
