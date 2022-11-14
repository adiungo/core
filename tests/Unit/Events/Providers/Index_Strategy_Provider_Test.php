<?php

namespace Adiungo\Core\Tests\Unit\Events\Providers;


use Adiungo\Core\Events\Providers\Index_Strategy_Provider;
use Adiungo\Core\Factories\Index_Strategy;
use Adiungo\Core\Tests\Test_Case;
use Mockery;

class Index_Strategy_Provider_Test extends Test_Case
{

    /**
     * @covers \Adiungo\Core\Events\Providers\Index_Strategy_Provider::get_model
     *
     * @return void
     */
    public function test_can_get_content_model(): void
    {
        $mock = Mockery::mock(Index_Strategy::class);
        $provider = new Index_Strategy_Provider($mock);

        $this->assertSame($mock, $provider->get_index_strategy());
    }

}