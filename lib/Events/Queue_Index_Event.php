<?php

namespace Adiungo\Core\Events;


use Adiungo\Core\Abstracts\Index_Strategy_Builder;
use Adiungo\Core\Events\Providers\Index_Strategy_Provider;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Unknown_Registry_Item;
use Underpin\Interfaces\Singleton;
use Underpin\Traits\With_Broadcaster;
use Underpin\Traits\With_Instance;

class Queue_Index_Event implements Singleton
{
    use With_Instance;
    use With_Broadcaster;

    protected function get_broadcaster_key(Index_Strategy_Builder $builder): string
    {
        return $builder->get_index_strategy()->get_data_source()::class . '__' . $builder->get_model();
    }

    /**
     * Attach a callback to the specified index event.
     *
     * @param Index_Strategy_Builder $builder
     * @param callable $callback
     * @return void
     * @throws Operation_Failed
     * @throws Unknown_Registry_Item
     */
    public function attach(Index_Strategy_Builder $builder, callable $callback): void
    {
        $this->get_broadcaster()->attach($this->get_broadcaster_key($builder), $callback);
    }

    /**
     * Detach a callback from the specified index event.
     *
     * @throws Operation_Failed
     */
    public function detach(Index_Strategy_Builder $builder, callable $callback): void
    {
        $this->get_broadcaster()->detach($this->get_broadcaster_key($builder), $callback);
    }

    /**
     * Broadcasts this event.
     *
     * @param Index_Strategy_Builder $builder
     * @return void
     */
    public function broadcast(Index_Strategy_Builder $builder): void
    {
        $this->get_broadcaster()->broadcast($this->get_broadcaster_key($builder), new Index_Strategy_Provider($builder->get_index_strategy()));
    }
}