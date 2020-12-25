<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class CategoryIndexTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_returns_a_collection_of_categories()
    {
        $cats = factory(Category::class, 2)->create();

        $response =
            $this->json('GET', 'api/categories');
        $cats->each(function ($cat) use ($response) {
            $response->assertJsonFragment([
                'slug' => $cat->slug
            ]);
        });
    }

    public function test_it_returns_only_parent_categories()
    {
        $cat = factory(Category::class)->create();

        $cat->children()->save(
            factory(Category::class)->create()
        );
        $this->json('GET', 'api/categories')
            ->assertJsonCount(1, 'data');
    }

    public function test_it_returns_categories_by_their_order()
    {
        $cat = factory(Category::class)->create([
            'order' => 1
        ]);
        $cat1 = factory(Category::class)->create([
            'order' => 2
        ]);

        $this->json('GET', 'api/categories')
            ->assertSeeInOrder([
                $cat->slug, $cat1->slug
            ]);
    }
}
