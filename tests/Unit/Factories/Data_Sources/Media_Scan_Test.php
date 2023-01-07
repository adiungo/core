<?php

namespace Adiungo\Core\Tests\Unit\Factories\Data_Sources;

use Adiungo\Core\Factories\Data_Sources\Media_Scan;
use Adiungo\Tests\Test_Case;

class Media_Scan_Test extends Test_Case
{
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

}