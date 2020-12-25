<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Tests\TestCase;

class ProductShowTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_fails_if_a_product_can_not_be_found()
    {
        $response = $this->json('GET','api/products/nope');

        $response->assertStatus(404);
    }

    public function test_it_show_a_product()
    {
        $product = factory(Product::class)->create();
        $response = $this->json('GET', "api/products/{$product->slug}");

        $response->assertJsonFragment([
            'id' => $product->id
        ]);
    }
}
