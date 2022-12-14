<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Traits\With_Response;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Generator;
use Mockery;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @covers \Adiungo\Core\Traits\With_Response::set_response
 * @covers \Adiungo\Core\Traits\With_Response::get_response
 */
class With_Response_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Response::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'response' => ['set_response', 'get_response', Mockery::mock(ResponseInterface::class)];
    }
}