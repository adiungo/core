<?php

namespace Adiungo\Core\Tests\Unit\Factories\Data_Sources;

use Adiungo\Core\Adapters\Node_To_Attachment_Collection_Builder;
use Adiungo\Core\Collections\Attachment_Collection;
use Adiungo\Core\Factories\Attachments\Audio;
use Adiungo\Core\Factories\Attachments\Image;
use Adiungo\Core\Factories\Attachments\Video;
use Adiungo\Core\Factories\Data_Sources\Media_Scan;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Inaccessible_Methods;
use Adiungo\Tests\Traits\With_Inaccessible_Properties;
use DOMAttr;
use DOMDocument;
use DOMNode;
use Masterminds\HTML5;
use Mockery;
use ReflectionException;
use Underpin\Exceptions\Operation_Failed;

class Media_Scan_Test extends Test_Case
{
    use With_Inaccessible_Methods;
    use With_Inaccessible_Properties;

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
            (new Attachment_Collection())->seed([(new Image())->set_id('1'), (new Image())->set_id('2')])
        );
        $instance->expects('get_collection_for_tag')->once()->with('video', Video::class)->andReturn(
            (new Attachment_Collection())->seed([(new Video())->set_id('3'), (new Video())->set_id('4')])
        );
        $instance->expects('get_collection_for_tag')->once()->with('audio', Audio::class)->andReturn(
            (new Attachment_Collection())->seed([(new Audio())->set_id('5'), (new Audio())->set_id('6')])
        );

        $result = $instance->get_data();

        $this->assertEquals(
            (new Attachment_Collection())->seed([
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

        $instance->allows('get_dom_document')->andReturn($document);
        $image_models = [
            (new Image())->set_id('123'),
            (new Image())->set_id('456'),
        ];
        $video_models = [
            (new Video())->set_id('789'),
            (new Video())->set_id('812'),
        ];

        $instance->expects('build_model_collection_from_node')->once()->withArgs(function ($node, $class_arg) {
            /** @var DOMAttr $src */
            $src = $node->attributes['src'];
            return $node instanceof DOMNode && $src->textContent === 'test.png' && $class_arg === Image::class;
        })->andReturn((new Attachment_Collection())->seed([$image_models[0]]));

        $instance->expects('build_model_collection_from_node')->once()->withArgs(function ($node, $class_arg) {
            /** @var DOMAttr $src */
            $src = $node->attributes['src'];
            return $node instanceof DOMNode && $src->textContent === 'test-3.png' && $class_arg === Image::class;
        })->andReturn((new Attachment_Collection())->seed([$image_models[1]]));

        $instance->expects('build_model_collection_from_node')->once()->withArgs(function ($node, $class_arg) {
            return $class_arg === Video::class;
        })->andReturn((new Attachment_Collection())->seed($video_models));

        $result_images = $this->call_inaccessible_method($instance, 'get_collection_for_tag', 'img', Image::class);
        $result_videos = $this->call_inaccessible_method($instance, 'get_collection_for_tag', 'video', Video::class);

        $this->assertEquals((new Attachment_Collection())->seed($image_models), $result_images);
        $this->assertEquals((new Attachment_Collection())->seed($video_models), $result_videos);
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\Media_Scan::build_model_collection_from_node()
     *
     * @return void
     * @throws ReflectionException
     */
    public function test_can_build_collection_from_node(): void
    {
        $instance = Mockery::mock(Media_Scan::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $node = new DOMNode();
        $class = Image::class;
        $builder = Mockery::mock(Node_To_Attachment_Collection_Builder::class);
        $expected = new Attachment_Collection();
        $instance->expects('get_attachment_builder_instance')->once()->with($node, $class)->andReturn($builder);
        $builder->expects('to_attachment_collection')->andReturn($expected);

        $result = $this->call_inaccessible_method($instance, 'build_model_collection_from_node', $node, $class);

        $this->assertSame($expected, $result);
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\Media_Scan::build_model_collection_from_node()
     *
     * @return void
     * @throws ReflectionException
     */
    public function test_can_get_attachment_builder_instance(): void
    {
        $instance = Mockery::mock(Media_Scan::class)->makePartial();
        $node = new DOMNode();
        $class = Image::class;
        $result = $this->call_inaccessible_method($instance, 'get_attachment_builder_instance', $node, $class);

        $this->assertInstanceOf(Node_To_Attachment_Collection_Builder::class, $result);

        $result_class = $this->get_protected_property($result, 'attachment')->getValue($result);
        $result_node = $this->get_protected_property($result, 'node')->getValue($result);

        $this->assertSame($node, $result_node);
        $this->assertSame($class, $result_class);
    }
}
