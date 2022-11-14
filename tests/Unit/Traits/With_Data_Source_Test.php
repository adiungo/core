<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Interfaces\Data_Source;
use Adiungo\Core\Tests\Test_Case;
use Adiungo\Core\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Adiungo\Core\Traits\With_Data_Source;
use Generator;
use Mockery;

class With_Data_Source_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Data_Source::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'data_source' => ['set_data_source', 'get_data_source', Mockery::mock(Data_Source::class)];
    }
}