<?php

namespace Adiungo\Core\Events;

use Adiungo\Core\Events\Providers\Index_Strategy_Provider;
use Adiungo\Core\Interfaces\Has_Index_Strategy;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Unknown_Registry_Item;
use Underpin\Interfaces\Identifiable_String;
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
     * @param string $id
     * @param callable $callback
     * @return void
     * @throws Operation_Failed
     * @throws Unknown_Registry_Item
     */
    public function attach(string $id, callable $callback): void
    {
        $this->get_broadcaster()->attach($id, $callback);
    }

    /**
     * Detach a callback from the specified index event.
     * @param string $id
     * @param callable $callback
     *
     * @throws Operation_Failed
     */
    public function detach(string $id, callable $callback): void
    {
        $this->get_broadcaster()->detach($id, $callback);
    }

    /**
     * Broadcasts this event.
     *
     * @param Has_Index_Strategy&Identifiable_String $builder
     * @return void
     */
    public function broadcast(Has_Index_Strategy&Identifiable_String $builder): void
    {
        if ($builder->get_id()) {
            $this->get_broadcaster()->broadcast($builder->get_id(), new Index_Strategy_Provider($builder->get_index_strategy()));
        }
    }
}
