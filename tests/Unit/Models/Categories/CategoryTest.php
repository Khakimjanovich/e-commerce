<?php

namespace Tests\Unit\Models\Categories;

use App\Models\Category;
use \Tests\TestCase;

class CategoryTest extends TestCase
{
    protected $category;

    /**
     * A basic unit test example.
     *
     * @return void
     */


    public function test_it_has_many_children()
    {
        $this->category->children()->save(
            factory(Category::class)->create()
        );
        $this->assertInstanceOf(Category::class, $this->category->children->first());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = factory(Category::class)->create();
    }
}
