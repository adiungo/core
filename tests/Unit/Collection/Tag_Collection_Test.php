<?php

namespace Adiungo\Core\Tests\Unit\Collection;


use Adiungo\Core\Collections\Tag_Collection;
use Adiungo\Core\Factories\Tag;
use Adiungo\Tests\Test_Case;
use Generator;
use Underpin\Exceptions\Operation_Failed;

class Tag_Collection_Test extends Test_Case
{

    /**
     * @covers       \Adiungo\Core\Collections\Tag_Collection::from_string
     *
     * @param Tag_Collection $expected
     * @param string $content
     * @return void
     * @throws Operation_Failed
     * @dataProvider provider_can_create_from_string
     */
    public function test_can_create_from_string(Tag_Collection $expected, string $content): void
    {
        $this->assertEquals($expected, (new Tag_Collection())->from_string($content));
    }

    /**
     * @throws Operation_Failed
     */
    public function provider_can_create_from_string(): Generator
    {
        yield 'content' => [
            (new Tag_Collection())
                ->add('content', Tag::from_string('#content'))
                ->add('project-adiungo', Tag::from_string('#ProjectAdiungo'))
                ->add('hashtags', Tag::from_string('#hashtags')),
            'This is a piece of #content about #ProjectAdiungo that should contain three #hashtags'
        ];


        yield 'duplicate hashtags' => [
            (new Tag_Collection())
                ->add('content', Tag::from_string('#content'))
                ->add('project-adiungo', Tag::from_string('#ProjectAdiungo'))
                ->add('hashtags', Tag::from_string('#hashtags')),
            'This is a piece of #content about #ProjectAdiungo that should contain three #hashtags, even though #content is added twice.'
        ];
    }
}