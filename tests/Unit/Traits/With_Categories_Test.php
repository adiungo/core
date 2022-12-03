<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Collections\Category_Collection;
use Adiungo\Core\Factories\Category;
use Adiungo\Core\Interfaces\Has_Categories;
use Adiungo\Core\Traits\With_Categories;
use Adiungo\Tests\Test_Case;
use Generator;
use Mockery;
use Underpin\Exceptions\Operation_Failed;

class With_Categories_Test extends Test_Case
{

    /**
     * @covers \Adiungo\Core\Traits\With_Categories::get_categories
     * @return void
     */
    public function test_can_get_categories(): void
    {
        $this->assertInstanceOf(Category_Collection::class, $this->get_instance()->get_categories());
    }

    protected function get_instance(): Has_Categories
    {
        return new class implements Has_Categories {
            use With_Categories;
        };
    }

    /**
     * @covers \Adiungo\Core\Traits\With_Categories::add_categories
     * @throws Operation_Failed
     */
    public function test_can_add_categories(): void
    {
        $category_1 = Mockery::mock(Category::class);
        $category_1->allows('get_id')->andReturn('a');

        $category_2 = Mockery::mock(Category::class);
        $category_2->allows('get_id')->andReturn('b');

        $category_3 = Mockery::mock(Category::class);
        $category_3->allows('get_id')->andReturn('c');

        $result = $this->get_instance()->add_categories($category_1, $category_2, $category_3)->get_categories()->to_array();
        $this->assertSame(['a' => $category_1, 'b' => $category_2, 'c' => $category_3], $result);
    }

    /**
     * @covers       \Adiungo\Core\Traits\With_Categories::has_categories
     * @param bool $expected
     * @param int $category_count
     * @return void
     * @throws Operation_Failed
     * @dataProvider provider_has_categories
     */
    public function test_has_categories(bool $expected, int $category_count): void
    {
        $result = $this->get_instance();

        for ($i = 0; $i < $category_count; $i++) {
            $mock = Mockery::mock(Category::class);
            $mock->allows('get_id')->andReturn('item_' . $i);
            $result->add_categories($mock);
        }

        $this->assertSame($expected, $result->has_categories());
    }

    /** @see test_has_categories * */
    public function provider_has_categories(): Generator
    {
        yield 'No categories' => [false, 0];
        yield 'One category' => [true, 1];
        yield 'Two categories' => [true, 2];
    }

    /**
     * @covers \Adiungo\Core\Traits\With_Categories::remove_categories
     * @throws Operation_Failed
     */
    public function test_can_remove_categories(): void
    {
        $category_1 = Mockery::mock(Category::class);
        $category_1->allows('get_id')->andReturn('a');

        $category_2 = Mockery::mock(Category::class);
        $category_2->allows('get_id')->andReturn('b');

        $category_3 = Mockery::mock(Category::class);
        $category_3->allows('get_id')->andReturn('c');

        $category_4 = Mockery::mock(Category::class);
        $category_4->allows('get_id')->andReturn('d');

        $result = $this->get_instance()->add_categories($category_1, $category_2, $category_3, $category_4)->remove_categories('a', 'b', 'c');
        $this->assertSame(['d' => $category_4], $result->get_categories()->to_array());
    }
}