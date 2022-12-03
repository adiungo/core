<?php

namespace Adiungo\Core\Tests\Unit\Factories\Data_Sources;

use Adiungo\Core\Factories\Data_Sources\CSV;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Inaccessible_Methods;
use Adiungo\Tests\Traits\With_Inaccessible_Properties;
use ParseCsv\Csv as CSV_Lib;
use ReflectionException;

class CSV_Test extends Test_Case
{
    use With_Inaccessible_Properties;
    use With_Inaccessible_Methods;

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
}
