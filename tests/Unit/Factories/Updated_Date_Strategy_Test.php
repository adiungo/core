<?php

namespace Adiungo\Core\Tests\Unit\Factories;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Collections\Content_Model_Collection;
use Adiungo\Core\Factories\Has_More_Strategies\Updated_Date_Strategy;
use Adiungo\Core\Interfaces\Has_Updated_Date;
use Adiungo\Core\Traits\With_Updated_Date;
use Adiungo\Tests\Test_Case;
use DateTime;
use Generator;
use Mockery;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Interfaces\Identifiable_String;
use Underpin\Traits\With_String_Identity;

class Updated_Date_Strategy_Test extends Test_Case
{
    /**
     * @covers \Adiungo\Core\Factories\Updated_Date_Strategy::get_oldest_model
     * @return void
     * @throws Operation_Failed
     */
    public function test_can_get_oldest_model(): void
    {
        $oldest = $this->get_mock()->set_updated_date(new DateTime('1 week ago'))->set_id('oldest');
        $newest = $this->get_mock()->set_updated_date(new DateTime('1 day ago'))->set_id('newest');
        $middle = $this->get_mock()->set_updated_date(new DateTime('6 days ago'))->set_id('middle');

        $collection = (new Content_Model_Collection())->seed([
            $middle,
            $oldest,
            $newest
        ]);

        $strategy = (new Updated_Date_Strategy())->set_content_model_collection($collection);
        $this->assertSame($strategy->get_oldest_model(), $oldest);
    }

    protected function get_mock(): Content_Model&Has_Updated_Date&Identifiable_String
    {
        return new class () extends Content_Model implements Has_Updated_Date, Identifiable_String {
            use With_Updated_Date;
            use With_String_Identity;
        };
    }

    /**
     * @covers       \Adiungo\Core\Factories\Updated_Date_Strategy::has_more
     * @param bool $expected
     * @param DateTime $updated_date
     * @param DateTime $model_updated_date
     * @return void
     * @throws Operation_Failed
     * @dataProvider provider_has_more
     */
    public function test_has_more(bool $expected, DateTime $updated_date, DateTime $model_updated_date): void
    {
        $instance = Mockery::mock(Updated_Date_Strategy::class)->makePartial();
        $instance->allows('get_updated_date')->andReturn($updated_date);
        $instance->allows('get_oldest_model->get_updated_date')->andReturn($model_updated_date);


        $this->assertSame($expected, $instance->has_more());
    }

    /**
     * @return Generator
     * @see test_has_more
     */
    protected function provider_has_more(): Generator
    {
        $same = new DateTime();
        yield 'updated date happened after the latest model update, return true' => [true, new DateTime(), new DateTime('1 second ago')];
        yield 'updated date happened before the latest model update, return true' => [false, new DateTime('1 second ago'), new DateTime()];
        yield 'update date happened at the exact same time as the latest model update, return true' => [true, $same, clone $same];
    }
}
