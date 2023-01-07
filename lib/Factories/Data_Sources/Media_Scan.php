<?php

namespace Adiungo\Core\Factories\Data_Sources;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Collections\Content_Model_Collection;
use Adiungo\Core\Interfaces\Data_Source;
use Adiungo\Core\Interfaces\Has_Base;
use Adiungo\Core\Interfaces\Has_Content;
use Adiungo\Core\Traits\With_Base;
use Adiungo\Core\Traits\With_Content;
use DOMDocument;
use DOMNode;
use Underpin\Factories\Url;
use Underpin\Traits\With_Object_Cache;

class Media_Scan implements Data_Source, Has_Content, Has_Base
{
    use With_Content;
    use With_Base;
    use With_Object_Cache;

    /**
     * @return Content_Model_Collection
     */
    public function get_data(): Content_Model_Collection
    {
        return new Content_Model_Collection();
    }

    /**
     * Fetches the dom document.
     *
     * @return DOMDocument
     */
    protected function get_dom_document(): DOMDocument
    {
        return new DOMDocument();
    }

    /**
     * @param string $tag
     * @param class-string $class
     * @return Content_Model_Collection
     */
    protected function get_collection_for_tag(string $tag, string $class): Content_Model_Collection
    {
        return new Content_Model_Collection();
    }

    /**
     * @param string $src
     * @return Url
     */
    protected function get_src_url(string $src): Url
    {
        return new Url();
    }

    /**
     * Traverse up the dom to determine if this node is a child of the specified tag.
     *
     * @param string $tag The parent tag
     * @param DOMNode $node The node to use when searching for the tag.
     * @return bool
     */
    protected function is_child(string $tag, DomNode $node): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function has_more(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function get_next(): Data_Source
    {
        return $this;
    }

    /**
     * Fetches the item from the specified URL.
     * @param int|string $id
     * @return Content_Model
     */
    public function get_item(int|string $id): Content_Model
    {
        return new class extends Content_Model{
            public function get_id(): string|int|null
            {
                return 123;
            }
        };
    }
}