<?php

namespace Adiungo\Core\Tests\Unit\Abstracts;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Events\Content_Model_Event;
use Adiungo\Core\Events\Providers\Content_Model_Provider;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Inaccessible_Methods;
use Mockery;
use ReflectionException;

class Content_Model_Test extends Test_Case
{
    use With_Inaccessible_Methods;

    /**
     * @covers \Adiungo\Core\Abstracts\Content_Model::save
     *
     * @return void
     */
    public function test_can_save(): void
    {
        $model = Mockery::mock(Content_Model::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $provider = Mockery::mock(Content_Model_Provider::class);

        $model->allows('get_content_model_provider')->andReturn($provider);
        $model->expects('get_content_model_event->broadcast')->with('save', $provider);

        $model->save();
    }

    /**
     * @covers \Adiungo\Core\Abstracts\Content_Model::delete
     *
     * @return void
     */
    public function test_can_delete(): void
    {
        $model = Mockery::mock(Content_Model::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $provider = Mockery::mock(Content_Model_Provider::class);

        $model->allows('get_content_model_provider')->andReturn($provider);
        $model->expects('get_content_model_event->broadcast')->with('delete', $provider);

        $model->delete();
    }

    /**
     * @covers \Adiungo\Core\Abstracts\Content_Model::get_content_model_event
     *
     * @throws ReflectionException
     */
    public function test_can_get_content_model_event(): void
    {
        $instance = Mockery::mock(Content_Model::class)->makePartial();
        $another_instance = Mockery::mock(Content_Model::class)->makePartial();

        $event = $this->call_inaccessible_method($instance, 'get_content_model_event');
        $again = $this->call_inaccessible_method($another_instance, 'get_content_model_event');
        $this->assertInstanceOf(Content_Model_Event::class, $event);

        // Validate that both models fetch the singleton instance.
        $this->assertSame($again, $event);
    }

    /**
     * @covers \Adiungo\Core\Abstracts\Content_Model::get_content_model_provider
     *
     * @throws ReflectionException
     */
    public function test_can_get_content_model_provider(): void
    {
        $instance = Mockery::mock(Content_Model::class);

        /** @var Content_Model_Provider $result */
        $result = $this->call_inaccessible_method($instance, 'get_content_model_provider');

        $this->assertSame($result->get_model(), $instance);
    }
}