<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Collections\Attachment_Collection;
use Adiungo\Core\Interfaces\Attachment;
use Adiungo\Core\Interfaces\Has_Attachments;
use Adiungo\Core\Traits\With_Attachments;
use Adiungo\Tests\Test_Case;
use Generator;
use Mockery;
use Underpin\Exceptions\Operation_Failed;

class With_Attachments_Test extends Test_Case
{

    /**
     * @covers \Adiungo\Core\Traits\With_Attachments::get_attachments
     * @return void
     */
    public function test_can_get_attachments(): void
    {
        $this->assertInstanceOf(Attachment_Collection::class, $this->get_instance()->get_attachments());
    }

    protected function get_instance(): Has_Attachments
    {
        return new class implements Has_Attachments {
            use With_Attachments;
        };
    }

    /**
     * @covers \Adiungo\Core\Traits\With_Attachments::add_attachments
     * @throws Operation_Failed
     */
    public function test_can_add_attachments(): void
    {
        $attachment_1 = Mockery::mock(Attachment::class);
        $attachment_1->allows('get_id')->andReturn('a');

        $attachment_2 = Mockery::mock(Attachment::class);
        $attachment_2->allows('get_id')->andReturn('b');

        $attachment_3 = Mockery::mock(Attachment::class);
        $attachment_3->allows('get_id')->andReturn('c');

        $result = $this->get_instance()->add_attachments($attachment_1, $attachment_2, $attachment_3)->get_attachments()->to_array();
        $this->assertSame(['a' => $attachment_1, 'b' => $attachment_2, 'c' => $attachment_3], $result);
    }

    /**
     * @covers       \Adiungo\Core\Traits\With_Attachments::has_attachments
     * @param bool $expected
     * @param int $attachment_count
     * @return void
     * @throws Operation_Failed
     * @dataProvider provider_has_attachments
     */
    public function test_has_attachments(bool $expected, int $attachment_count): void
    {
        $result = $this->get_instance();

        for ($i = 0; $i < $attachment_count; $i++) {
            $mock = Mockery::mock(Attachment::class);
            $mock->allows('get_id')->andReturn('item_' . $i);
            $result->add_attachments($mock);
        }

        $this->assertSame($expected, $result->has_attachments());
    }

    /** @see test_has_attachments * */
    public function provider_has_attachments(): Generator
    {
        yield 'No attachments' => [false, 0];
        yield 'One attachment' => [true, 1];
        yield 'Two attachments' => [true, 2];
    }

    /**
     * @covers \Adiungo\Core\Traits\With_Attachments::remove_attachments
     * @throws Operation_Failed
     */
    public function test_can_remove_attachments(): void
    {
        $attachment_1 = Mockery::mock(Attachment::class);
        $attachment_1->allows('get_id')->andReturn('a');

        $attachment_2 = Mockery::mock(Attachment::class);
        $attachment_2->allows('get_id')->andReturn('b');

        $attachment_3 = Mockery::mock(Attachment::class);
        $attachment_3->allows('get_id')->andReturn('c');

        $attachment_4 = Mockery::mock(Attachment::class);
        $attachment_4->allows('get_id')->andReturn('d');

        $result = $this->get_instance()->add_attachments($attachment_1, $attachment_2, $attachment_3, $attachment_4)->remove_attachments('a', 'b', 'c');
        $this->assertSame(['d' => $attachment_4], $result->get_attachments()->to_array());
    }
}