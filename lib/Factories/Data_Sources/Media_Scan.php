<?php

namespace Adiungo\Core\Factories\Data_Sources;

use Adiungo\Core\Abstracts\Attachment;
use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Adapters\Node_To_Attachment_Collection_Builder;
use Adiungo\Core\Collections\Attachment_Collection;
use Adiungo\Core\Collections\Content_Model_Collection;
use Adiungo\Core\Factories\Attachments\Audio;
use Adiungo\Core\Factories\Attachments\Image;
use Adiungo\Core\Factories\Attachments\Video;
use Adiungo\Core\Interfaces\Data_Source;
use Adiungo\Core\Interfaces\Has_Base;
use Adiungo\Core\Interfaces\Has_Content;
use Adiungo\Core\Traits\With_Base;
use Adiungo\Core\Traits\With_Content;
use DOMDocument;
use DOMElement;
use Masterminds\HTML5;
use Underpin\Exceptions\Item_Not_Found;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Validation_Failed;
use Underpin\Traits\With_Object_Cache;

class Media_Scan implements Data_Source, Has_Content, Has_Base
{
    use With_Content;
    use With_Base;
    use With_Object_Cache;

    /**
     * @return Attachment_Collection
     * @throws Operation_Failed
     */
    public function get_data(): Attachment_Collection
    {
        return $this->get_collection_for_tag('img', Image::class)->merge(
            $this->get_collection_for_tag('video', Video::class),
            $this->get_collection_for_tag('audio', Audio::class)
        );
    }

    /**
     * Fetches the dom document.
     *
     * @return DOMDocument
     */
    protected function get_dom_document(): DOMDocument
    {
        return $this->load_from_cache('dom', fn () => (new HTML5())->parse($this->get_content()));
    }

    /**
     * @param string $tag
     * @param class-string<Attachment> $class
     * @return Attachment_Collection
     * @throws Operation_Failed
     */
    protected function get_collection_for_tag(string $tag, string $class): Attachment_Collection
    {
        $items = $this->get_dom_document()->getElementsByTagName($tag);
        $collection = new Attachment_Collection();

        /** @var DOMElement $element * */
        foreach ($items as $element) {
            $model_collection = $this->build_model_collection_from_node($element, $class);
            if ($model_collection) {
                $collection = $collection->merge($model_collection);
            }
        }

        return $collection;
    }

    /**
     * Builds the content model from the provided node.
     *
     * @param DOMElement $element The node from which the model should be built.
     * @param class-string<Content_Model> $class The class to instantiate
     * @return Content_Model_Collection|null
     */
    protected function build_model_collection_from_node(DOMElement $element, string $class): ?Content_Model_Collection
    {
        try {
            return $this->get_attachment_builder_instance($element, $class)->to_attachment_collection();
        } catch (Validation_Failed $e) {
            return null;
        }
    }

    /**
     * @param DOMElement $element The node from which the model should be built.
     * @param class-string<Content_Model> $class The class to instantiate
     * @return Node_To_Attachment_Collection_Builder
     */
    protected function get_attachment_builder_instance(DOMElement $element, string $class): Node_To_Attachment_Collection_Builder
    {
        return new Node_To_Attachment_Collection_Builder($element, $class);
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
     * @param int|string $id The content source
     * @return Content_Model
     * @throws Item_Not_Found
     * @throws Operation_Failed
     */
    public function get_item(int|string $id): Content_Model
    {
        /** @var ?Content_Model $item */
        $item = $this->get_data()->query()->key_in($id)->find();

        if (!$item) {
            throw new Item_Not_Found("No item with that ID exists in this content.");
        }

        return $item;
    }
}
