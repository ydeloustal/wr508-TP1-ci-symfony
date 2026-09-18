<?php

namespace App\Entity;

final class Product
{
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly float $price,
        private readonly int $stock,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }
}
