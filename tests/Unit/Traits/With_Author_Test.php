<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Tests\Test_Case;
use Adiungo\Core\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Adiungo\Core\Traits\With_Author;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Author::set_author
 * @covers \Adiungo\Core\Traits\With_Author::get_author
 */
class With_Author_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Author::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'author' => ['set_author', 'get_author', 'Myles Standish'];
    }
}