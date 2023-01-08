<?php

namespace Adiungo\Core\Tests\Unit\Factories\Data_Sources;

use Adiungo\Core\Collections\Content_Model_Collection;
use Adiungo\Core\Factories\Attachments\Audio;
use Adiungo\Core\Factories\Attachments\Image;
use Adiungo\Core\Factories\Attachments\Video;
use Adiungo\Core\Factories\Data_Sources\Media_Scan;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Inaccessible_Methods;
use DOMAttr;
use DOMDocument;
use DOMNode;
use DOMNodeList;
use Masterminds\HTML5;
use Mockery;
use ReflectionException;
use Underpin\Exceptions\Operation_Failed;

class Media_Scan_Test extends Test_Case
{
    use With_Inaccessible_Methods;

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\Media_Scan::has_more
     *
     * @return void
     */
    public function test_has_more_returns_false(): void
    {
        $this->assertSame(false, (new Media_Scan())->has_more());
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\Media_Scan::has_more
     *
     * @return void
     */
    public function test_get_next_returns_static(): void
    {
        $instance = new Media_Scan();
        $this->assertSame($instance, $instance->get_next());
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\Media_Scan::get_dom_document
     *
     * @return void
     * @throws ReflectionException
     */
    public function test_can_get_dom_document(): void
    {
        $instance = Mockery::mock(Media_Scan::class)->makePartial();

        $instance->allows('get_content')->andReturn('<p>foo</p>');

        /** @var DOMDocument $result */
        $result = $this->call_inaccessible_method($instance, 'get_dom_document');
        $this->assertEquals('foo', $result->textContent);
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\Media_Scan::get_data()
     * @return void
     * @throws Operation_Failed
     */
    public function test_can_get_data(): void
    {
        $instance = Mockery::mock(Media_Scan::class)->shouldAllowMockingProtectedMethods()->makePartial();

        $instance->expects('get_collection_for_tag')->once()->with('img', Image::class)->andReturn(
            (new Content_Model_Collection())->seed([(new Image())->set_id('1'), (new Image())->set_id('2')])
        );
        $instance->expects('get_collection_for_tag')->once()->with('video', Video::class)->andReturn(
            (new Content_Model_Collection())->seed([(new Video())->set_id('3'), (new Video())->set_id('4')])
        );
        $instance->expects('get_collection_for_tag')->once()->with('audio', Audio::class)->andReturn(
            (new Content_Model_Collection())->seed([(new Audio())->set_id('5'), (new Audio())->set_id('6')])
        );

        $result = $instance->get_data();

        $this->assertEquals(
            (new Content_Model_Collection())->seed([
                (new Image())->set_id('1'),
                (new Image())->set_id('2'),
                (new Video())->set_id('3'),
                (new Video())->set_id('4'),
                (new Audio())->set_id('5'),
                (new Audio())->set_id('6'),
            ]),
            $result
        );
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\Media_Scan::get_collection_for_tag()
     *
     * @return void
     * @throws Operation_Failed
     * @throws ReflectionException
     */
    public function test_can_get_collection_for_tag(): void
    {
        $instance = Mockery::mock(Media_Scan::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $document = (new HTML5())->parse('
          <img src="test.png"/>
          <video width="320" height="240" controls>
             <source src="movie.mp4" type="video/mp4">
             <source src="movie.ogg" type="video/ogg">
             Your browser does not support the video tag.
          </video> 
          <img src="test-3.png"/>
        ');

        $class = Image::class;
        $instance->allows('get_dom_document')->andReturn($document);
        $model = (new Image())->set_id('123');

        $instance->expects('build_model_from_node')->once()->withArgs(function ($node, $class_arg) use ($class) {
            /** @var DOMAttr $src */
            $src = $node->attributes['src'];
            return $node instanceof DOMNode && $src->textContent === 'test.png' && $class_arg === $class;
        })->andReturn($model);

        $instance->expects('build_model_from_node')->once()->withArgs(function ($node, $class_arg) use ($class) {
            /** @var DOMAttr $src */
            $src = $node->attributes['src'];
            return $node instanceof DOMNode && $src->textContent === 'test-3.png' && $class_arg === $class;
        })->andReturn(null);

        $result = $this->call_inaccessible_method($instance,'get_collection_for_tag', 'img', $class);

        $this->assertEquals((new Content_Model_Collection())->seed([$model]), $result);
    }
}
