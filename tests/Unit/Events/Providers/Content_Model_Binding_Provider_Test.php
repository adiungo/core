<?php

namespace Adiungo\Core\Tests\Unit\Events\Providers;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Events\Providers\Content_Model_Binding_Provider;
use Adiungo\Tests\Test_Case;
use Mockery;
use Mockery\MockInterface;

class Content_Model_Binding_Provider_Test extends Test_Case
{
    /**
     * @covers \Adiungo\Core\Events\Providers\Content_Model_Provider::get_models
     *
     * @return void
     */
    public function test_can_get_content_models(): void
    {
        /** @var Content_Model&MockInterface $mock */
        $mock = Mockery::mock(Content_Model::class);
        /** @var Content_Model&MockInterface $mock_b */
        $mock_b = Mockery::mock(Content_Model::class);

        $mock->allows('get_id')->andReturn(123);
        $mock_b->allows('get_id')->andReturn(456);
        $provider = new Content_Model_Binding_Provider($mock, $mock_b);

        $this->assertSame([123 => $mock, 456 => $mock_b], $provider->get_models()->to_array());
    }
}
