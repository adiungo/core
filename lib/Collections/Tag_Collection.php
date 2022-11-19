<?php

namespace Adiungo\Core\Collections;

use Adiungo\Core\Factories\Tag;
use Underpin\Abstracts\Registries\Object_Registry;
use Underpin\Exceptions\Operation_Failed;

class Tag_Collection extends Object_Registry
{
    protected string $abstraction_class = Tag::class;

    final public function __construct()
    {
    }

    /**
     * @throws Operation_Failed
     */
    public static function from_string(string $content): static
    {
        $result = new static();
        preg_match_all('/#([\w]+)/', $content, $tags);

        // Bail early if we couldn't find any tags.
        if (!isset($tags[1])) {
            return $result;
        }

        foreach ($tags[1] as $tag) {
            $tag = Tag::from_string($tag);

            if (!is_string($tag->get_id())) {
                throw new Operation_Failed('Could not create tag from string', 500, 'error');
            }

            $result->add($tag->get_id(), $tag);
        }

        return $result;
    }
}