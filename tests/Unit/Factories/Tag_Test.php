<?php

namespace Adiungo\Core\Tests\Unit\Factories;

use Adiungo\Core\Factories\Tag;
use Adiungo\Tests\Test_Case;
use Generator;
use Underpin\Exceptions\Operation_Failed;

class Tag_Test extends Test_Case
{
    /**
     * @covers       \Adiungo\Core\Factories\Tag::from_string
     *
     * @param Tag $expected
     * @param string $tag
     * @return void
     * @dataProvider provider_can_get_from_string
     * @throws Operation_Failed
     */
    public function test_can_get_from_string(Tag $expected, string $tag): void
    {
        $this->assertEquals($expected, Tag::from_string($tag));
    }

    /** @see test_can_get_from_string */
    public function provider_can_get_from_string(): Generator
    {
        yield 'with camel case' => [(new Tag())->set_id('this-is-a-hashtag')->set_name('This Is A Hashtag'), '#ThisIsAHashtag'];
        yield 'without camel case' => [(new Tag())->set_id('thishashtag')->set_name('Thishashtag'), '#Thishashtag'];
        yield 'with dashes' => [(new Tag())->set_id('this-hashtag')->set_name('This Hashtag'), '#this-hashtag'];
        yield 'with underscores' => [(new Tag())->set_id('this-hashtag')->set_name('This Hashtag'), '#this_hashtag'];
        yield 'with numbers' => [(new Tag())->set_id('this-hashtag234')->set_name('This Hashtag234'), '#thisHashtag234'];
    }

    /**
     * @param string $expected
     * @param Tag $tag
     * @return void
     * @dataProvider provider_can_convert_to_string
     */
    public function test_can_convert_to_string(string $expected, Tag $tag): void
    {
        $this->assertEquals($expected, $tag->to_string());
        $this->assertEquals($expected, (string)$tag);
    }

    /** @see test_can_convert_to_string */
    public function provider_can_convert_to_string(): Generator
    {
        yield 'Happy Path' => ['#ThisIsAHashtag', (new Tag())->set_name('This Is A Hashtag')];
        yield 'Mixed Case' => ['#ThisIsAHashtag', (new Tag())->set_name('ThIs IS a HashTAG')];
        yield 'Lower Case' => ['#ThisIsAHashtag', (new Tag())->set_name('this is a hashtag')];
        yield 'without camel case' => ['#Thishashtag', (new Tag())->set_name('Thishashtag')];
        yield 'with numbers' => ['#ThisHashtag234', (new Tag())->set_name('This Hashtag234')];
    }
}
