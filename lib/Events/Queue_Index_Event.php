<?php

namespace Adiungo\Core\Events;

use Adiungo\Core\Events\Providers\Index_Strategy_Provider;
use Adiungo\Core\Interfaces\Has_Index_Strategy;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Unknown_Registry_Item;
use Underpin\Interfaces\Singleton;
use Underpin\Traits\With_Broadcaster;
use Underpin\Traits\With_Instance;

class Queue_Index_Event implements Singleton
{
    use With_Instance;
    use With_Broadcaster;

    /**
     * Attach a callback to the specified index event.
     *
     * @param class-string<Has_Index_Strategy> $builder
     * @param callable $callback
     * @return void
     * @throws Operation_Failed
     * @throws Unknown_Registry_Item
     */
    public function attach(string $builder, callable $callback): void
    {
        $this->get_broadcaster()->attach($builder, $callback);
    }

    /**
     * Detach a callback from the specified index event.
     * @param class-string<Has_Index_Strategy> $builder
     * @param callable $callback
     *
     * @throws Operation_Failed
     */
    public function detach(string $builder, callable $callback): void
    {
        $this->get_broadcaster()->detach($builder, $callback);
    }

    /**
     * Broadcasts this event.
     *
     * @param Has_Index_Strategy $builder
     * @return void
     */
    public function broadcast(Has_Index_Strategy $builder): void
    {
        $this->get_broadcaster()->broadcast($builder::class, new Index_Strategy_Provider($builder->get_index_strategy()));
    }
}
