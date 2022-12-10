<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Interfaces\Has_Paginated_Request;
use Adiungo\Core\Traits\With_Batch_Request_Builder;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Content_Model_Collection::set_author
 * @covers \Adiungo\Core\Traits\With_Content_Model_Collection::get_author
 */
class With_Batch_Request_Builder_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Batch_Request_Builder::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'content-model-instance' => ['set_batch_request_builder', 'get_batch_request_builder', Mockery::mock(Has_Paginated_Request::class)];
    }
}