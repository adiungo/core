<?php

namespace Adiungo\Core\Tests\Unit\Traits;

use Adiungo\Core\Traits\With_Slug;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Slug::set_slug
 * @covers \Adiungo\Core\Traits\With_Slug::get_slug
 */
class With_Slug_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Slug::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'slug' => ['set_slug', 'get_slug', 'hello-world'];
    }
}
