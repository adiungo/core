<?php

namespace Adiungo\Core\Factories;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Interfaces\Has_Name;
use Adiungo\Core\Traits\With_Name;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Helpers\String_Helper;
use Underpin\Interfaces\Can_Convert_To_String;
use Underpin\Interfaces\Identifiable_String;
use Underpin\Traits\With_String_Identity;

class Tag extends Content_Model implements Identifiable_String, Has_Name, Can_Convert_To_String
{
    use With_String_Identity;
    use With_Name;

    final public function __construct()
    {
    }

    /**
     * Generates a tag object from a hashtag string.
     *
     * @param string $hash_tag
     * @return static
     * @throws Operation_Failed
     */
    public static function from_string(string $hash_tag): static
    {
        // Strip hashmark off the front, if it's there.
        $tag = String_Helper::trim_leading($hash_tag, '#');

        // If this happens to be camel case, break it into multiple words.
        $name = preg_replace('/(?<=[A-Z])(?=[A-Z][a-z])|(?<=[a-z])(?=[A-Z])/', '$1 $2', $tag);

        if (!$name) {
            throw new Operation_Failed('Could not create tag from provided string', 500, 'error');
        }

        // If the name has underscores or dashes, replace them with spaces.
        $name = ucwords(str_replace('-', ' ', str_replace('_', ' ', $name)));

        // And ID is just a slugified version of this.
        $id = strtolower(str_replace(' ', '-', $name));

        // Set the name, processed to the best of our abilities.
        return (new static())->set_id($id)->set_name($name);
    }

    /**
     * Magic method for string conversion.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->to_string();
    }

    /**
     * Converts this tag into a hashtag.
     *
     * @return string
     */
    public function to_string(): string
    {
        return String_Helper::prepend(str_replace(' ', '', ucwords(strtolower($this->get_name()))), '#');
    }
}
