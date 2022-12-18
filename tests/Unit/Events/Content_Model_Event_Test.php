<?php

namespace Adiungo\Core\Tests\Unit\Events;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Events\Content_Model_Event;
use Adiungo\Core\Events\Providers\Content_Model_Provider;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Inaccessible_Methods;
use Mockery;
use ReflectionException;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Unknown_Registry_Item;

class Content_Model_Event_Test extends Test_Case
{
    use With_Inaccessible_Methods;

    /**
     * @covers \Adiungo\Core\Events\Content_Model_Event::get_broadcaster_key
     *
     * @return void
     * @throws ReflectionException
     */
    public function test_can_get_broadcaster_key(): void
    {
        $instance = new Content_Model_Event();

        $this->assertEquals('Model_Foo_Bar_Baz__save', $this->call_inaccessible_method($instance, 'get_broadcaster_key', 'Model_Foo_Bar_Baz', 'save'));
    }

    /**
     * @covers \Adiungo\Core\Events\Content_Model_Event::attach
     *
     * @return void
     * @throws Unknown_Registry_Item
     * @throws Operation_Failed
     */
    public function test_can_attach(): void
    {
        $instance = Mockery::mock(Content_Model_Event::class);
        $instance->shouldAllowMockingProtectedMethods()->makePartial();
        $model = 'Model_Custom';
        $action = 'delete';
        $callback = fn () => '';

        $instance->allows('get_broadcaster_key')->with($model, $action)->andReturn('foo');
        $instance->expects('get_broadcaster->attach')->with('foo', $callback);

        $instance->attach($model, $action, $callback);
    }

    /**
     * @covers \Adiungo\Core\Events\Content_Model_Event::detach
     *
     * @return void
     * @throws Operation_Failed
     */
    public function test_can_detach(): void
    {
        $instance = Mockery::mock(Content_Model_Event::class);
        $instance->shouldAllowMockingProtectedMethods()->makePartial();
        $model = 'Model_Custom';
        $action = 'delete';
        $callback = fn () => '';

        $instance->allows('get_broadcaster_key')->with($model, $action)->andReturn('foo');
        $instance->expects('get_broadcaster->detach')->with('foo', $callback);

        $instance->detach($model, $action, $callback);
    }

    /**
     * @covers \Adiungo\Core\Events\Content_Model_Event::broadcast
     *
     * @return void
     */
    public function test_can_broadcast(): void
    {
        $instance = Mockery::mock(Content_Model_Event::class);
        $instance->shouldAllowMockingProtectedMethods()->makePartial();

        $model = Mockery::mock(Content_Model::class);

        $provider = new Content_Model_Provider($model);
        $action = 'delete';

        $instance->allows('get_broadcaster_key')->with($model::class, $action)->andReturn('foo');
        $instance->expects('get_broadcaster->broadcast')->with('foo', $provider);

        $instance->broadcast($action, $provider);
    }
}
