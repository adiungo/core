<?php

namespace Adiungo\Core\Events;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Events\Providers\Content_Model_Binding_Provider;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Unknown_Registry_Item;
use Underpin\Helpers\Array_Helper;
use Underpin\Interfaces\Singleton;
use Underpin\Traits\With_Broadcaster;
use Underpin\Traits\With_Instance;

class Content_Model_Bind_Event implements Singleton
{
    use With_Broadcaster;
    use With_Instance;

    /**
     * Attaches an action to this event.
     *
     * @param class-string<Content_Model> $model_a One of the two models to be bound.
     * @param class-string<Content_Model> $model_b The other bound model.
     * @param string $action The action to take with these two models
     * @param callable $callback The callback to call when this action is ran.
     * @return void
     * @throws Operation_Failed
     * @throws Unknown_Registry_Item
     */
    public function attach(string $model_a, string $model_b, string $action, callable $callback): void
    {
        $this->get_broadcaster()->attach($this->get_broadcaster_key($model_a, $model_b, $action), $callback);
    }

    /**
     * Generates a normalized broadcaster key based on the provided models and actions.
     *
     * @param class-string<Content_Model> $model_a One of the two models to be bound.
     * @param class-string<Content_Model> $model_b The other bound model.
     * @param string $action The action to take with these two models
     * @return string
     */
    protected function get_broadcaster_key(string $model_a, string $model_b, string $action): string
    {
        return Array_Helper::process([$model_a, $model_b])->sort()->set_separator('_')->to_string() . '__' . $action;
    }

    /**
     * Detaches an action from this event.
     *
     * @param class-string<Content_Model> $model_a One of the two models to be bound.
     * @param class-string<Content_Model> $model_b The other bound model.
     * @param string $action The action to take with these two models
     * @param callable $callback The callback to call when this action is ran.
     * @return void
     * @throws Operation_Failed
     */
    public function detach(string $model_a, string $model_b, string $action, callable $callback): void
    {
        $this->get_broadcaster()->detach($this->get_broadcaster_key($model_a, $model_b, $action), $callback);
    }

    /**
     * Broadcasts an action against two bound models.
     *
     * @param string $action The action to take
     * @param Content_Model_Binding_Provider $provider The provider containing both models.
     * @return void
     */
    public function broadcast(string $action, Content_Model_Binding_Provider $provider): void
    {
        $models = Array_Helper::values($provider->get_models()->to_array());
        $this->get_broadcaster()->broadcast($this->get_broadcaster_key($models[0]::class, $models[1]::class, $action), $provider);
    }
}
