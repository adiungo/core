<?php

namespace Adiungo\Core\Tests\Unit\Factories\Data_Sources;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Factories\Data_Sources\CSV;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Inaccessible_Methods;
use Adiungo\Tests\Traits\With_Inaccessible_Properties;
use Generator;
use Mockery;
use ParseCsv\Csv as CSV_Lib;
use ReflectionException;
use Underpin\Enums\Types;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Factories\Registry;

class CSV_Test extends Test_Case
{
    use With_Inaccessible_Properties;
    use With_Inaccessible_Methods;

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\CSV::convert_to_model
     *
     * @throws ReflectionException
     */
    public function test_can_convert_to_model(): void
    {
        $instance = Mockery::mock(CSV::class)->shouldAllowMockingProtectedMethods()->makePartial();

        Mockery::namedMock('Test_Mock', Content_Model::class);

        $items = ['a' => 'set_a', 'b' => 'set_b', 'c' => 'set_c', 'd' => 'set_d'];

        $instance->expects('set_mapped_property')->times(count($items))->withArgs(function ($key, $item, $model) use ($items) {
            if ("Test_Mock" instanceof $model) {
                return false;
            }

            return $items[$key] === $item;
        });
        $instance->allows('get_content_model_instance')->andReturn('Test_Mock');

        $this->call_inaccessible_method($instance, 'convert_to_model', $items);
    }

    /**
     * @covers       \Adiungo\Core\Factories\Data_Sources\CSV::set_mapped_property()
     *
     * @param mixed $expected
     * @param mixed $value
     * @param array{type:Types, setter:string} $mapping
     * @throws ReflectionException
     * @dataProvider provider_set_mapped_property
     */
    public function test_can_set_mapped_property(mixed $expected, mixed $value, array $mapping): void
    {
        $source = Mockery::mock(CSV::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $source->allows('get_mappings->get')->with('key')->andReturn($mapping);

        $model = Mockery::mock(Content_Model::class);
        $model->expects($mapping['setter'])->with($expected)->andReturn($model);

        $this->call_inaccessible_method($source, 'set_mapped_property', 'key', $value, $model);
    }

    public function provider_set_mapped_property(): Generator
    {
        yield 'it converts types' => [6, '6', ['setter' => 'set_int', 'type' => Types::Integer]];
        yield 'it sets values' => ['alex', 'alex', ['setter' => 'set_name', 'type' => Types::String]];
    }

    /**
     * @covers       \Adiungo\Core\Factories\Data_Sources\CSV::mapping_is_valid
     *
     * @throws ReflectionException
     * @dataProvider provider_mapping_is_valid
     */
    public function test_mapping_is_valid(bool $expected, string $setter): void
    {
        $mock = new class () extends Content_Model {
            public function get_id(): string|int|null
            {
                return 123;
            }

            public function set_test_value(): void
            {
                return;
            }
        };

        $instance = Mockery::mock(CSV::class);
        $instance->allows('get_content_model_instance')->andReturn($mock::class);

        $this->assertSame($expected, $this->call_inaccessible_method($instance, 'mapping_is_valid', $setter, Types::String));
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\CSV::get_mappings
     * @throws ReflectionException
     */
    public function test_can_get_mappings(): void
    {
        $source = new CSV();
        $item = $this->call_inaccessible_method($source, 'get_mappings');
        $item_again = $this->call_inaccessible_method($source, 'get_mappings');

        $this->assertSame($item, $item_again);
        $this->assertInstanceOf(Registry::class, $item);
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\CSV::get_csv_instance
     *
     * @return void
     * @throws ReflectionException
     */
    public function test_can_get_csv_instance(): void
    {
        $source = new CSV();
        $item = $this->call_inaccessible_method($source, 'get_csv_instance');
        $item_again = $this->call_inaccessible_method($source, 'get_csv_instance');

        $this->assertSame($item, $item_again);
        $this->assertInstanceOf(CSV_Lib::class, $item);
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\CSV::map_column
     * @return void
     * @throws Operation_Failed
     */
    public function test_can_map_column(): void
    {
        $instance = Mockery::mock(CSV::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $column = 'foo';
        $setter = 'bar';
        $type = Types::String;
        $instance->expects('get_mappings->add')->with($column, ['setter' => $setter, 'type' => $type]);

        $this->assertSame($instance, $instance->map_column($column, $setter, $type));
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\CSV::map_column
     * @return void
     * @throws Operation_Failed
     */
    public function test_can_map_column_catches_thrown_exceptions(): void
    {
        $instance = Mockery::mock(CSV::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $column = 'foo';
        $instance->allows('get_content_model_instance')->andReturn('Mocked_Model');
        $setter = 'bar';
        $type = Types::String;
        $instance->expects('get_mappings->add')->with($column, ['setter' => $setter, 'type' => $type])->andThrow(Operation_Failed::class);

        $this->expectException(Operation_Failed::class);
        $this->expectExceptionMessage("Column mapping failed - The $setter method cannot be found on the Mocked_Model model.");

        $instance->map_column($column, $setter, $type);
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\CSV::set_csv
     * @throws ReflectionException
     */
    public function test_can_set_csv(): void
    {
        $source = new CSV();
        $expected = 'a,b,c,1,2,3';
        $source->set_csv($expected);

        $property = $this->get_protected_property($source, 'csv');

        $this->assertSame($expected, $property->getValue($source));
    }

    /** @see test_mapping_is_valid */
    protected function provider_mapping_is_valid(): Generator
    {
        yield 'valid setter returns true' => [true, 'set_test_value'];
        yield 'invalid setter returns false' => [false, 'invalid'];
    }
}
