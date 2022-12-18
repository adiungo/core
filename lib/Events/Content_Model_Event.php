<?php

namespace Adiungo\Core\Events;

use Adiungo\Core\Events\Providers\Content_Model_Provider;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Unknown_Registry_Item;
use Underpin\Interfaces\Singleton;
use Underpin\Traits\With_Broadcaster;
use Underpin\Traits\With_Instance;

class Content_Model_Event implements Singleton
{
    use With_Broadcaster;
    use With_Instance;

    /**
     * Attach a callback to the specified model action.
     *
     * @param string $model The model class name, EG: Model::class
     * @param string $action The action, such as "save" or "delete"
     * @param callable $callback The function to call when this action is broadcasted.
     * @return void
     * @throws Operation_Failed
     * @throws Unknown_Registry_Item
     */
    public function attach(string $model, string $action, callable $callback): void
    {
        $this->get_broadcaster()->attach($this->get_broadcaster_key($model, $action), $callback);
    }

    /**
     * Generates a model key using the provided arguments.
     *
     * @param string $model The model class name, EG: Model::class
     * @param string $action The action.
     * @return string The model key.
     */
    protected function get_broadcaster_key(string $model, string $action): string
    {
        return $model . '__' . $action;
    }

    /**
     * Detach a callback from the specified model action.
     *
     * @param string $model The model class name, EG: Model::class
     * @param string $action The action, such as "save" or "delete"
     * @param callable $callback The function to prevent from calling when this action is broadcasted.
     * @return void
     * @throws Operation_Failed
     */
    public function detach(string $model, string $action, callable $callback): void
    {
        $this->get_broadcaster()->detach($this->get_broadcaster_key($model, $action), $callback);
    }

    /**
     * @param string $action The action, such as "save" or "delete"
     * @param Content_Model_Provider $provider The model provider containing the model that is being broadcasted.
     * @return void
     */
    public function broadcast(string $action, Content_Model_Provider $provider): void
    {
        $this->get_broadcaster()->broadcast($this->get_broadcaster_key($provider->get_model()::class, $action), $provider);
    }
}
