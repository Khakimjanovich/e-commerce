<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_returns_a_collection_of_posts()
    {
        $products = factory(Product::class)->create();

        $this->json('GET', 'api/products')
            ->assertJsonFragment([
                'id' => $products->id
            ]);

    }

    public function test_it_has_paginated_data()
    {
        $this->json('GET', 'api/products')
            ->assertJsonStructure([
                'links',
                'data'
            ]);
    }
}
