<?php

namespace Tests\Unit\Models\Categories;

use App\Models\Category;
use App\Models\Product;
use \Tests\TestCase;

class CategoryTest extends TestCase
{

    /**
     * A basic unit test example.
     *
     * @return void
     */


    public function test_it_has_many_children()
    {
        $cat = factory(Category::class)->create();
        $cat->children()->save(
            factory(Category::class)->create()
        );
        $this->assertInstanceOf(Category::class, $cat->children->first());
    }

    public function test_it_can_fetch_only_parents()
    {
        $cat = factory(Category::class)->create();
        $cat->children()->save(
            factory(Category::class)->create()
        );
        $this->assertEquals(1, Category::parents()->count());
    }

    public function test_it_is_orderable_by_a_numeric_order()
    {
        $cat = factory(Category::class)->create([
            'order' => 1
        ]);
        $cat2 = factory(Category::class)->create([
            'order' => 2
        ]);
        $this->assertEquals($cat->name, Category::ordered()->first()->name);
    }

    public function test_it_has_many_products()
    {
        $cat = factory(Category::class)->create();
        if ($cat instanceof Category) {
            $cat->products()->save(
                factory(Product::class)->create()
            );
        }
        $this->assertInstanceOf(Product::class, $cat->products->first());
    }
}
