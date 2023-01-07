<?php

namespace Adiungo\Core\Tests\Unit\Factories\Adapters\Has_More_Strategies;

use Adiungo\Core\Factories\Has_More_Strategies\Has_All_Ids_Strategy;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Inaccessible_Methods;
use Adiungo\Tests\Traits\With_Inaccessible_Properties;
use Generator;
use Mockery;
use ReflectionException;

class Has_All_Ids_Strategy_Test extends Test_Case
{
    use With_Inaccessible_Properties;
    use With_Inaccessible_Methods;

    /**
     * @covers       \Adiungo\Core\Factories\Has_More_Strategies\Has_All_Ids_Strategy::collection_count_is_equal_to_items_per_page
     * @param bool $expected
     * @param int $per_page
     * @throws ReflectionException
     * @dataProvider provider_collection_count_is_equal_to_items_per_page
     * @return void
     */
    public function test_collection_count_is_equal_to_items_per_page(bool $expected, int $per_page): void
    {
        $strategy = Mockery::mock(Has_All_Ids_Strategy::class)->makePartial();
        $strategy->allows('get_content_model_collection->to_array')->andReturn(['foo', 'bar']);
        $this->set_protected_property($strategy, 'per_page', $per_page);

        $result = $this->call_inaccessible_method($strategy, 'collection_count_is_equal_to_items_per_page');

        $this->assertSame($expected, $result);
    }

    /** @see test_collection_count_is_equal_to_items_per_page */
    public function provider_collection_count_is_equal_to_items_per_page(): Generator
    {
        yield 'returns true if count is equal to items per page' => [true, 2];
        yield 'returns false if count is not equal to items per page' => [false, 1];
    }

    /**
     * @covers       \Adiungo\Core\Factories\Has_More_Strategies\Has_All_Ids_Strategy::collection_count_is_equal_to_items_per_page
     * @param bool $expected
     * @param int $requested_count
     * @throws ReflectionException
     * @dataProvider provider_collection_count_is_equal_to_requested_count
     * @return void
     */
    public function test_collection_count_is_equal_to_requested_count(bool $expected, int $requested_count): void
    {
        $strategy = Mockery::mock(Has_All_Ids_Strategy::class)->makePartial();
        $strategy->allows('get_content_model_collection->to_array')->andReturn(['foo', 'bar']);
        $this->set_protected_property($strategy, 'requested_count', $requested_count);

        $result = $this->call_inaccessible_method($strategy, 'collection_count_is_equal_to_requested_count');

        $this->assertSame($expected, $result);
    }

    /** @see test_collection_count_is_equal_to_requested_count */
    public function provider_collection_count_is_equal_to_requested_count(): Generator
    {
        yield 'returns true if count is equal to items per page' => [true, 2];
        yield 'returns false if count is not equal to items per page' => [false, 1];
    }

    /**
     * @param bool $has_more
     * @param bool $collection_count_is_equal_to_items_per_page
     * @param bool $collection_count_is_equal_to_requested_count
     * @return void
     * @dataProvider provider_has_more
     */
    public function test_has_more(bool $has_more, bool $collection_count_is_equal_to_items_per_page, bool $collection_count_is_equal_to_requested_count): void
    {
        $strategy = Mockery::mock(Has_All_Ids_Strategy::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $strategy->allows('collection_count_is_equal_to_items_per_page')
            ->andReturn($collection_count_is_equal_to_items_per_page);

        $strategy->allows('collection_count_is_equal_to_requested_count')
            ->andReturn($collection_count_is_equal_to_requested_count);

        $this->assertSame($has_more, $strategy->has_more());
    }

    /** @see test_has_more */
    public function provider_has_more(): Generator
    {
        yield 'it does not have more when the received items equals the number of items per page and the requested count' => [false, true, true];
        yield 'it does not have more when when the collection count is equal to the requested count' => [false, false, true];
        yield 'it does not have more when the received items equals the number of items per page' => [false, true, false];
        yield 'it does have more when the received items is not equal the number of items per page or the requested count' => [true, false, false];
    }
}