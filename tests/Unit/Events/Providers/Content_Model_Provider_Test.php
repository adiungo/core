<?php

namespace Adiungo\Core\Tests\Unit\Events\Providers;


use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Events\Providers\Content_Model_Provider;
use Adiungo\Core\Tests\Test_Case;
use Mockery;

class Content_Model_Provider_Test extends Test_Case
{

    /**
     * @covers \Adiungo\Core\Events\Providers\Content_Model_Provider::get_model
     *
     * @return void
     */
    public function test_can_get_content_model(): void
    {
        $mock = Mockery::mock(Content_Model::class);
        $provider = new Content_Model_Provider($mock);

        $this->assertSame($mock, $provider->get_model());
    }

}