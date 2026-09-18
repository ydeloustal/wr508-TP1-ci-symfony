<?php

namespace App\Entity;

final class Cart
{
    /** @var array<int, int> */
    private array $items = [];

    public function add(Product $product, int $quantity): void
    {
        $this->items[$product->getId()] += $quantity;
    }

    /**
     * @return array<int, int>
     */
    public function items(): array
    {
        return $this->items;
    }

    public function getContent(): string
    {
        return 'panier de '.count($this->items).' article(s)';
    }
}
