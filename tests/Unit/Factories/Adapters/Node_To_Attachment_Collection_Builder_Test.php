<?php

namespace Adiungo\Core\Tests\Unit\Factories\Adapters;

use Adiungo\Core\Adapters\Node_To_Attachment_Collection_Builder;
use Adiungo\Core\Factories\Attachments\Image;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Inaccessible_Methods;
use DOMNode;
use Masterminds\HTML5;
use ReflectionException;

class Node_To_Attachment_Collection_Builder_Test extends Test_Case
{
    use With_Inaccessible_Methods;

    /**
     * @covers \Adiungo\Core\Adapters\Node_To_Attachment_Collection_Builder::is_child()
     * @throws ReflectionException
     */
    public function test_can_verify_if_is_child(): void
    {
        $html = (new HTML5())->parse('<section><aside><div><blockquote><p>Hello!</p></blockquote></div></aside></section>');
        /** @var DOMNode $item */
        $item = $html->getElementsByTagName('blockquote')->item(0);
        $instance = new Node_To_Attachment_Collection_Builder($item, Image::class);

        $this->assertTrue($this->call_inaccessible_method($instance, 'is_child', 'aside', $item));
        $this->assertTrue($this->call_inaccessible_method($instance, 'is_child', 'div', $item));
        $this->assertTrue($this->call_inaccessible_method($instance, 'is_child', 'section', $item));
        $this->assertFalse($this->call_inaccessible_method($instance, 'is_child', 'p', $item));
        $this->assertFalse($this->call_inaccessible_method($instance, 'is_child', 'h1', $item));
    }
}