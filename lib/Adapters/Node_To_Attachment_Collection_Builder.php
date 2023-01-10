<?php

namespace Adiungo\Core\Adapters;

use Adiungo\Core\Abstracts\Attachment;
use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Collections\Attachment_Collection;
use Adiungo\Core\Factories\Attachments\Image;
use Adiungo\Core\Interfaces\Can_Convert_To_Attachment_Collection;
use DOMAttr;
use DOMNode;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Validation_Failed;
use Underpin\Helpers\Array_Helper;

class Node_To_Attachment_Collection_Builder implements Can_Convert_To_Attachment_Collection
{
    /**
     * @param DOMNode $node The node from which the model should be built.
     * @param class-string<Content_Model> $attachment The class to instantiate
     */
    public function __construct(protected DOMNode $node, protected string $attachment)
    {
    }

    /**
     * @return Attachment_Collection
     * @throws Validation_Failed
     */
    public function to_attachment_collection(): Attachment_Collection
    {
        return Array_Helper::reduce($this->validate()->get_sources(), [$this, 'add_attachment'], new Attachment_Collection());
    }

    /**
     * @return static
     * @throws Validation_Failed
     */
    protected function validate(): static
    {
        if($this->is_child('pre', $this->node)) {
            throw new Validation_Failed('Node is a child of a pre tag and is probably not intended to be fetched.', type: 'notice');
        }

        if($this->is_child('code', $this->node)) {
            throw new Validation_Failed('Node is a child of a code tag and is probably not intended to be fetched.', type: 'notice');
        }

        return $this;
    }

    /**
     * Adds an attachment to the given collection from the given source.
     *
     * @param Attachment_Collection $acc
     * @param DOMAttr $source
     * @return Attachment_Collection
     * @throws Operation_Failed
     */
    protected function add_attachment(Attachment_Collection $acc, DOMAttr $source): Attachment_Collection
    {
        $attachment = $this->build_attachment_from_attribute($source);
        return $acc->add($attachment->get_id(), $attachment);
    }

    /**
     * Builds the attachment using the provided attribute.
     *
     * @param DOMAttr $src
     * @return Attachment
     */
    protected function build_attachment_from_attribute(DOMAttr $src): Attachment
    {
        return new Image();
    }

    /**
     * Fetches the src using the input node. Will attempt to fetch the src from child source tags if src is not in the\
     * parent.
     * @return DOMAttr[]
     */
    protected function get_sources(): array
    {
        return [];
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
        if (!$node->parentNode) {
            return false;
        }

        if ($node->parentNode->nodeName === $tag) {
            return true;
        }

        return $this->is_child($tag, $node->parentNode);
    }

    /**
     * Returns true if the provided node has a src attribute.
     *
     * @param DOMNode $node
     * @return bool
     */
    protected function has_src_attribute(DOMNode $node): bool
    {
        return false;
    }
}
