<?php

namespace Adiungo\Core\Tests\Unit\Traits;

use Adiungo\Core\Collections\Content_Model_Collection;
use Adiungo\Core\Traits\With_Content_Model_Collection;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Content_Model_Collection::set_author
 * @covers \Adiungo\Core\Traits\With_Content_Model_Collection::get_author
 */
class With_Content_Model_Collection_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Content_Model_Collection::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'content-model-instance' => ['set_content_model_collection', 'get_content_model_collection', new Content_Model_Collection()];
    }
}
