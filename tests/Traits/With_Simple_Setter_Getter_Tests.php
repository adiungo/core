<?php

namespace Adiungo\Core\Tests\Traits;


use Generator;

trait With_Simple_Setter_Getter_Tests
{

    protected object $instance;

    /**
     * @param string $setter
     * @param string $getter
     * @param string $value
     *
     * @return void
     * @dataProvider get_setters_and_getters
     */
    public function test_can_set_and_get_items(string $setter, string $getter, mixed $value): void
    {
        if (method_exists($this, 'assertSame')) {
            // Gets value
            $this->assertSame($value, $this->instance->$setter($value)->$getter());
        }
    }

    abstract protected function get_setters_and_getters(): Generator;

}