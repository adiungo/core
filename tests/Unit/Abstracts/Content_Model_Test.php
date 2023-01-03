<?php

namespace Adiungo\Core\Tests\Unit\Abstracts;

use Adiungo\Core\Abstracts\Attachment;
use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Collections\Attachment_Collection;
use Adiungo\Core\Collections\Category_Collection;
use Adiungo\Core\Collections\Tag_Collection;
use Adiungo\Core\Events\Content_Model_Bind_Event;
use Adiungo\Core\Events\Content_Model_Event;
use Adiungo\Core\Events\Providers\Content_Model_Binding_Provider;
use Adiungo\Core\Events\Providers\Content_Model_Provider;
use Adiungo\Core\Factories\Category;
use Adiungo\Core\Factories\Tag;
use Adiungo\Core\Interfaces\Has_Attachments;
use Adiungo\Core\Interfaces\Has_Categories;
use Adiungo\Core\Interfaces\Has_Tags;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Inaccessible_Methods;
use Mockery;
use Mockery\MockInterface;
use ReflectionException;
use Underpin\Exceptions\Operation_Failed;

class Content_Model_Test extends Test_Case
{
    use With_Inaccessible_Methods;

    /**
     * @covers \Adiungo\Core\Abstracts\Content_Model::broadcast_category_binding_events
     *
     * @return void
     * @throws ReflectionException
     * @throws Operation_Failed
     */
    public function test_can_broadcast_category_binding_events(): void
    {
        /** @var Content_Model&MockInterface $model */
        $model = Mockery::mock(Content_Model::class, Has_Tags::class, Has_Categories::class, Has_Attachments::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $action = 'delete';

        $model->allows('get_categories')->andReturn((new Category_Collection())->seed([
            (new Category())->set_id('1'),
            (new Category())->set_id('2'),
        ]));

        $model->allows('get_tags')->andReturn((new Tag_Collection())->seed([
            (new Tag())->set_id('5'),
            (new Tag())->set_id('9'),
            (new Tag())->set_id('11'),
        ]));

        $model->allows('get_attachments')->andReturn((new Attachment_Collection())->seed([
            Mockery::mock(Attachment::class)->makePartial()->set_id('2'),
            Mockery::mock(Attachment::class)->makePartial()->set_id('54'),
            Mockery::mock(Attachment::class)->makePartial()->set_id('52'),
            Mockery::mock(Attachment::class)->makePartial()->set_id('56'),
        ]));

        $model->expects('broadcast_model_bind_event')->twice()->withArgs(fn ($action_arg, $model) => $action_arg === $action && $model instanceof Category);
        $model->expects('broadcast_model_bind_event')->times(3)->withArgs(fn ($action_arg, $model) => $action_arg === $action && $model instanceof Tag);
        $model->expects('broadcast_model_bind_event')->times(4)->withArgs(fn ($action_arg, $model) => $action_arg === $action && $model instanceof Attachment);

        $result = $this->call_inaccessible_method($model, 'broadcast_binding_events', $action);
    }

    /**
     * @covers \Adiungo\Core\Abstracts\Content_Model::broadcast_model_bind_event
     *
     * @return void
     * @throws ReflectionException
     */
    public function test_can_broadcast_model_bind_event(): void
    {
        $model = Mockery::namedMock('Model_A', Content_Model::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $model_b = Mockery::namedMock('Model_B', Content_Model::class);

        $model->allows('get_id')->andReturn(123);
        $model_b->allows('get_id')->andReturn(456);
        $action = 'save';
        $model->expects('get_content_model_bind_event_instance->broadcast')
            ->withArgs(function (string $action_arg, Content_Model_Binding_Provider $provider_arg) use ($action, $model, $model_b) {
                return $action === $action_arg && $provider_arg->get_models()->to_array() === [123 => $model, 456 => $model_b];
            });

        $this->call_inaccessible_method($model, 'broadcast_model_bind_event', $action, $model_b);
    }

    /**
     * @covers \Adiungo\Core\Abstracts\Content_Model::get_content_model_bind_event_instance
     * @return void
     * @throws ReflectionException
     */
    public function test_can_get_content_model_bind_event_instance(): void
    {
        $this->assertInstanceOf(Content_Model_Bind_Event::class, $this->call_inaccessible_method(Mockery::mock(Content_Model::class), 'get_content_model_bind_event_instance'));
    }

    /**
     * @covers \Adiungo\Core\Abstracts\Content_Model::get_content_model_event
     * @return void
     * @throws ReflectionException
     */
    public function test_can_get_content_model_event_instance(): void
    {
        $this->assertInstanceOf(Content_Model_Event::class, $this->call_inaccessible_method(Mockery::mock(Content_Model::class), 'get_content_model_event'));
    }

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
        $model->expects('broadcast_binding_events')->with('save');

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
        $model->expects('broadcast_binding_events')->with('delete');

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
