<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Abstracts\Single_Response_Adapter;
use Adiungo\Core\Traits\With_Single_Response_Adapter;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Single_Response_Adapter::set_data_source
 * @covers \Adiungo\Core\Traits\With_Single_Response_Adapter::get_data_source
 */
class With_Single_Response_Adapter_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Single_Response_Adapter::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'data_source' => ['set_single_response_adapter', 'get_single_response_adapter', Mockery::mock(Single_Response_Adapter::class)];
    }
}