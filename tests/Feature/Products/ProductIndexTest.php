<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_returns_a_collection_of_categories()
    {
        $products = factory(Product::class, 2)->create();

        $response =
            $this->json('GET', 'api/products');
        $products->each(function ($product) use ($response) {
            $response->assertJsonFragment([
                'id' => $product->id
            ]);
        });
    }
}
