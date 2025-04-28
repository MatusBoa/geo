<?php

declare(strict_types=1);

namespace Container\Product\Api\V1;

use Tests\TestCase;
use App\Container\Product\Model\Product;
use App\Container\Product\UI\Api\V1\RequestFilter\ProductApiRequestFilter;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\Group('api')]
final class ProductApiControllerTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsProducts(): void
    {
        $product = Product::factory()->create();

        $this->get('/api/v1/products')->assertOk()
            ->assertJsonCount(1, 'items')
            ->assertJsonPath('items.0.id', $product->getId());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itThrowsNotFoundIfSpecificProductDoesNotExist(): void
    {
        $this->get('/api/v1/products/1234567890')
            ->assertNotFound();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itReturnsSpecificProduct(): void
    {
        $product = Product::factory()->create();

        $this->get('/api/v1/products/' . $product->getId())
            ->assertOk()
            ->assertJsonPath('id', $product->getId());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itThrowsUnprocessableWhenCreatingProductWithInvalidPayload(): void
    {
        $this->post('/api/v1/products', [
            'foo' => 'bar',
        ])->assertUnprocessable();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itCreatesProduct(): void
    {
        $this->post('/api/v1/products', [
            ProductApiRequestFilter::FIELD_NAME => 'fooBar',
            ProductApiRequestFilter::FIELD_PRICE => 10.0,
        ])->assertCreated();

        $this->assertDatabaseCount(Product::class, 1);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itFullyUpdatesProduct(): void
    {
        $product = Product::factory()->create([
            Product::ATTR_NAME => 'foo',
            Product::ATTR_PRICE => 10.20,
        ]);

        $this->put('/api/v1/products/' . $product->getId(), [
            ProductApiRequestFilter::FIELD_NAME => 'bar',
            ProductApiRequestFilter::FIELD_PRICE => 10.40,
        ])->assertOk();

        $this->assertDatabaseHas(Product::class, [
            Product::ATTR_NAME => 'bar',
            Product::ATTR_PRICE => 10.40,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itPartiallyUpdatesProduct(): void
    {
        $product = Product::factory()->create([
            Product::ATTR_NAME => 'foo',
        ]);

        $this->patch('/api/v1/products/' . $product->getId(), [
            ProductApiRequestFilter::FIELD_NAME => 'bar',
        ])->assertOk();

        $this->assertDatabaseHas(Product::class, [
            Product::ATTR_NAME => 'bar',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itThrowsNotFoundWhenDeletingNonExistingProduct(): void
    {
        $this->delete('/api/v1/products/1234567890')
            ->assertNotFound();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itDeletesProduct(): void
    {
        $product = Product::factory()->create();

        $this->delete('/api/v1/products/' . $product->getId())->assertNoContent();

        $this->assertDatabaseEmpty(Product::class);
    }
}
