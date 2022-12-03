<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Factories\Adapters\Data_Source_Adapter;
use Adiungo\Core\Traits\With_Data_Source_Adapter;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Data_Source_Adapter::set_data_source
 * @covers \Adiungo\Core\Traits\With_Data_Source_Adapter::get_data_source
 */
class With_Data_Source_Adapter_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Data_Source_Adapter::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'data_source' => ['set_data_source_adapter', 'get_data_source_adapter', Mockery::mock(Data_Source_Adapter::class)];
    }
}