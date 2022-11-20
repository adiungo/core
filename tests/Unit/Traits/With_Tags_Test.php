<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Collections\Tag_Collection;
use Adiungo\Core\Factories\Tag;
use Adiungo\Core\Interfaces\Has_Tags;
use Adiungo\Core\Tests\Test_Case;
use Adiungo\Core\Traits\With_Tags;
use Generator;
use Mockery;
use Underpin\Exceptions\Operation_Failed;

class With_Tags_Test extends Test_Case
{

    /**
     * @covers \Adiungo\Core\Traits\With_Tags::get_tags
     * @return void
     */
    public function test_can_get_tags(): void
    {
        $this->assertInstanceOf(Tag_Collection::class, $this->get_instance()->get_tags());
    }

    protected function get_instance(): Has_Tags
    {
        return new class implements Has_Tags {
            use With_Tags;
        };
    }

    /**
     * @covers \Adiungo\Core\Traits\With_tags::add_tags
     * @throws Operation_Failed
     */
    public function test_can_add_tags(): void
    {
        $tag_1 = Mockery::mock(Tag::class);
        $tag_1->allows('get_id')->andReturn('a');

        $tag_2 = Mockery::mock(Tag::class);
        $tag_2->allows('get_id')->andReturn('b');

        $tag_3 = Mockery::mock(Tag::class);
        $tag_3->allows('get_id')->andReturn('c');

        $result = $this->get_instance()->add_tags($tag_1, $tag_2, $tag_3)->get_tags()->to_array();
        $this->assertSame(['a' => $tag_1, 'b' => $tag_2, 'c' => $tag_3], $result);
    }

    /**
     * @covers       \Adiungo\Core\Traits\With_Tags::has_tags
     * @param bool $expected
     * @param int $tag_count
     * @return void
     * @throws Operation_Failed
     * @dataProvider provider_has_tags
     */
    public function test_has_tags(bool $expected, int $tag_count): void
    {
        $result = $this->get_instance();

        for ($i = 0; $i < $tag_count; $i++) {
            $mock = Mockery::mock(Tag::class);
            $mock->allows('get_id')->andReturn('item_' . $i);
            $result->add_tags($mock);
        }

        $this->assertSame($expected, $result->has_tags());
    }

    /** @see test_has_tags * */
    public function provider_has_tags(): Generator
    {
        yield 'No tags' => [false, 0];
        yield 'One tag' => [true, 1];
        yield 'Two tags' => [true, 2];
    }

    /**
     * @covers \Adiungo\Core\Traits\With_Tags::remove_tags
     * @throws Operation_Failed
     */
    public function test_can_remove_tags(): void
    {
        $tag_1 = Mockery::mock(Tag::class);
        $tag_1->allows('get_id')->andReturn('a');

        $tag_2 = Mockery::mock(Tag::class);
        $tag_2->allows('get_id')->andReturn('b');

        $tag_3 = Mockery::mock(Tag::class);
        $tag_3->allows('get_id')->andReturn('c');

        $tag_4 = Mockery::mock(Tag::class);
        $tag_4->allows('get_id')->andReturn('d');

        $result = $this->get_instance()->add_tags($tag_1, $tag_2, $tag_3, $tag_4)->remove_tags('a', 'b', 'c');
        $this->assertSame(['d' => $tag_4], $result->get_tags()->to_array());
    }

    /**
     * @covers \Adiungo\Core\Traits\With_Tags::import_tags
     * @return void
     * @throws Operation_Failed
     */
    public function test_can_import_tags(): void
    {
        $instance = $this->get_instance()->import_tags('#this', 'and #that', 'but not this #this again');

        $this->assertEquals((new Tag_Collection())->seed([
            (new Tag())->set_name('This')->set_id('this'),
            (new Tag())->set_name('That')->set_id('that')
        ]), $instance->get_tags());
    }

}