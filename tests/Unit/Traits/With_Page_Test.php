<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Traits\With_Page;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Page::set_page
 * @covers \Adiungo\Core\Traits\With_Page::get_page
 */
class With_Page_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Page::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'page' => ['set_page', 'get_page', 1988];
    }
}