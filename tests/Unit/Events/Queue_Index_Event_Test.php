<?php

namespace Adiungo\Core\Tests\Unit\Events;

use Adiungo\Core\Events\Providers\Index_Strategy_Provider;
use Adiungo\Core\Events\Queue_Index_Event;
use Adiungo\Core\Factories\Index_Strategy;
use Adiungo\Core\Interfaces\Has_Index_Strategy;
use Adiungo\Core\Traits\With_Index_Strategy;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Inaccessible_Methods;
use Mockery;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Unknown_Registry_Item;
use Underpin\Interfaces\Identifiable_String;

class Queue_Index_Event_Test extends Test_Case
{
    use With_Inaccessible_Methods;

    /**
     * @covers \Adiungo\Core\Events\Queue_Index_Event::attach
     *
     * @return void
     * @throws Unknown_Registry_Item
     * @throws Operation_Failed
     */
    public function test_can_attach(): void
    {
        $instance = Mockery::mock(Queue_Index_Event::class);
        $instance->shouldAllowMockingProtectedMethods()->makePartial();

        $callback = fn () => '';

        $instance->expects('get_broadcaster->attach')->with('foo', $callback);

        $instance->attach('foo', $callback);
    }

    /**
     * @covers \Adiungo\Core\Events\Queue_Index_Event::detach
     *
     * @return void
     * @throws Operation_Failed
     */
    public function test_can_detach(): void
    {
        $instance = Mockery::mock(Queue_Index_Event::class);
        $instance->shouldAllowMockingProtectedMethods()->makePartial();

        $callback = fn () => '';

        $instance->expects('get_broadcaster->detach')->with('bar', $callback);

        $instance->detach('bar', $callback);
    }

    /**
     * @covers \Adiungo\Core\Events\Queue_Index_Event::broadcast
     *
     * @return void
     */
    public function test_can_broadcast(): void
    {
        $instance = Mockery::mock(Queue_Index_Event::class);
        $instance->shouldAllowMockingProtectedMethods()->makePartial();

        $strategy = Mockery::mock(Index_Strategy::class);

        /** @var Mockery\MockInterface&Has_Index_Strategy&Identifiable_String $index_strategy_builder */
        $index_strategy_builder = $this->create_builder()->set_index_strategy($strategy);

        $instance->expects('get_broadcaster->broadcast')->withArgs(function ($key, $strategy_test) use ($strategy) {
            return $key === 'baz' && $strategy_test instanceof Index_Strategy_Provider && $strategy_test->get_index_strategy() === $strategy;
        });


        $instance->broadcast($index_strategy_builder);
    }

    /**
     * Creates a builder stub.
     *
     * @return Has_Index_Strategy
     */
    private function create_builder(): Has_Index_Strategy
    {
        return new class () implements Has_Index_Strategy, Identifiable_String {
            use With_Index_Strategy;

            public function get_id(): ?string
            {
                return 'baz';
            }

            public function set_id(?string $id): static
            {
                return $this;
            }
        };
    }
}
