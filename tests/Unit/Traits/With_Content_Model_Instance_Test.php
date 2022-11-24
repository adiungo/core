<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Tests\Test_Case;
use Adiungo\Core\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Adiungo\Core\Traits\With_Content_Model_Instance;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Content_Model_Instance::set_author
 * @covers \Adiungo\Core\Traits\With_Content_Model_Instance::get_author
 */
class With_Content_Model_Instance_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Content_Model_Instance::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'content-model-instance' => ['set_content_model_instance', 'get_content_model_instance', Content_Model::class];
    }
}