<?php

namespace Adiungo\Core\Tests\Unit\Factories\Adapters;

use Adiungo\Core\Abstracts\Attachment;
use Adiungo\Core\Adapters\Node_To_Attachment_Collection_Builder;
use Adiungo\Core\Collections\Attachment_Collection;
use Adiungo\Core\Factories\Attachments\Image;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Inaccessible_Methods;
use Adiungo\Tests\Traits\With_Inaccessible_Properties;
use DOMAttr;
use DOMElement;
use Exception;
use Generator;
use Masterminds\HTML5;
use Mockery;
use ReflectionException;
use Underpin\Exceptions\Validation_Failed;

class Node_To_Attachment_Collection_Builder_Test extends Test_Case
{
    use With_Inaccessible_Methods;
    use With_Inaccessible_Properties;

    /**
     * @covers \Adiungo\Core\Adapters\Node_To_Attachment_Collection_Builder::is_child()
     * @throws ReflectionException
     */
    public function test_can_verify_if_is_child(): void
    {
        $html = (new HTML5())->parse('<section><aside><div><blockquote><p>Hello!</p></blockquote></div></aside></section>');
        /** @var DOMElement $item */
        $item = $html->getElementsByTagName('blockquote')->item(0);
        $instance = new Node_To_Attachment_Collection_Builder($item, Image::class);

        $this->assertTrue($this->call_inaccessible_method($instance, 'is_child', 'aside', $item));
        $this->assertTrue($this->call_inaccessible_method($instance, 'is_child', 'div', $item));
        $this->assertTrue($this->call_inaccessible_method($instance, 'is_child', 'section', $item));
        $this->assertFalse($this->call_inaccessible_method($instance, 'is_child', 'p', $item));
        $this->assertFalse($this->call_inaccessible_method($instance, 'is_child', 'h1', $item));
    }

    /**
     * @covers \Adiungo\Core\Adapters\Node_To_Attachment_Collection_Builder::to_attachment_collection()
     * @return void
     * @throws Validation_Failed
     */
    public function test_can_convert_to_attachment_collection(): void
    {
        $instance = Mockery::mock(Node_To_Attachment_Collection_Builder::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $expected = new Attachment_Collection();

        $instance->expects('validate')->andReturn($instance);

        $instance->expects('get_sources')
            ->andReturn([Mockery::mock(DOMAttr::class), Mockery::mock(DOMAttr::class)]);

        $instance->expects('add_attachment')->twice()->andReturn($expected);

        $this->assertSame($expected, $instance->to_attachment_collection());
    }

    /**
     * @covers \Adiungo\Core\Adapters\Node_To_Attachment_Collection_Builder::add_attachment()
     *
     * @return void
     * @throws ReflectionException
     */
    public function test_can_add_attachment(): void
    {
        $instance = Mockery::mock(Node_To_Attachment_Collection_Builder::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $source = Mockery::mock(DOMAttr::class);
        $attachment = Mockery::mock(Attachment::class);
        $id = 'foo';
        $attachment->allows('get_id')->andReturn($id);

        $registry = Mockery::mock(Attachment_Collection::class);
        $instance->expects('build_attachment_from_attribute')->with($source)->andReturn($attachment);

        $registry->expects('add')->once()->with($id, $attachment)->andReturn($registry);

        $this->assertSame($registry, $this->call_inaccessible_method($instance, 'add_attachment', $registry, $source));
    }

    /**
     * @covers       \Adiungo\Core\Adapters\Node_To_Attachment_Collection_Builder::validate()
     * @param ?class-string<Exception> $exception
     * @param string $tag
     * @return void
     * @throws ReflectionException
     * @dataProvider provider_can_validate
     */
    public function test_can_validate(?string $exception, string $tag): void
    {
        $instance = Mockery::mock(Node_To_Attachment_Collection_Builder::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $element = Mockery::mock(DOMElement::class);
        $this->set_protected_property($instance, 'element', $element);

        $instance->allows('is_child')->with('pre', $element)->andReturn($tag === 'pre');
        $instance->allows('is_child')->with('code', $element)->andReturn($tag === 'code');


        if ($exception) {
            $this->expectException($exception);
        }

        $result = $this->call_inaccessible_method($instance, 'validate');

        if (!$exception) {
            $this->assertSame($instance, $result);
        }
    }

    /** @see test_can_validate */
    public function provider_can_validate(): Generator
    {
        yield 'throws if child is pre' => [Validation_Failed::class, 'pre'];
        yield 'throws if child is code' => [Validation_Failed::class, 'code'];
        yield 'does not throw if passing' => [null, 'img'];
    }

    /**
     * @covers       \Adiungo\Core\Adapters\Node_To_Attachment_Collection_Builder::node_has_src_attributes()
     * @param bool $expected
     * @param string $html
     * @param string $tag
     * @return void
     * @throws ReflectionException
     * @dataProvider provider_can_determine_if_node_has_src_attributes
     */
    public function test_can_determine_if_node_has_src_attributes(bool $expected, string $html, string $tag): void
    {
        $element = (new HTML5())->parse($html)->getElementsByTagName($tag)->item(0);
        $instance = Mockery::mock(Node_To_Attachment_Collection_Builder::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $result = $this->call_inaccessible_method($instance, 'has_src_attribute', $element);

        $this->assertEquals($expected, $result);
    }

    public function provider_can_determine_if_node_has_src_attributes(): Generator
    {
        yield 'true if node has src attributes' => [true, '<img src="foo.jpg"/>', 'img'];
        yield 'false if node does not have a src attribute, but has other attributes' => [false, '<div class="bar"><p>hi</p></div>', 'div'];
        yield 'false if node does not have any attributes' => [false, '<h2>bar</h2>', 'h2'];
    }

    /**
     * @covers       \Adiungo\Core\Adapters\Node_To_Attachment_Collection_Builder::node_has_src_attributes()
     * @return void
     * @throws ReflectionException
     */
    public function test_node_has_src_attributes_returns_false_with_malformed_node(): void
    {
        $element = new DOMElement('invalid');

        $instance = Mockery::mock(Node_To_Attachment_Collection_Builder::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $result = $this->call_inaccessible_method($instance, 'has_src_attribute', $element);

        $this->assertFalse($result);
    }
}
