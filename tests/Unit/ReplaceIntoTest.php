<?php

namespace Napp\Core\Dbal\Tests\Unit;

use Napp\Core\Dbal\Tests\Stubs\Row;
use Napp\Core\Dbal\Tests\TestCase;

class ReplaceIntoTest extends TestCase
{
    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        Row::insert([
            'product_id' => 1,
            'warehouse_id' => 2,
            'quantity' => 343434
        ]);

        Row::insert([
            'product_id' => 2,
            'warehouse_id' => 1,
            'quantity' => 343434
        ]);

        Row::insert([
            'product_id' => 3,
            'warehouse_id' => 1,
            'quantity' => 34324
        ]);

        Row::insert([
            'product_id' => 4,
            'warehouse_id' => 2,
            'quantity' => 34324
        ]);

        Row::insert([
            'product_id' => 4,
            'warehouse_id' => 3,
            'quantity' => 34324
        ]);
    }

    public function test_can_replace_into()
    {
        Row::replace([
            'product_id' => 2,
            'warehouse_id' => 1,
            'quantity' => 22
        ]);

        $this->assertEquals(5, Row::count());
    }
}
