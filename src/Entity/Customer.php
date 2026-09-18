<?php

namespace App\Entity;

final class Customer
{
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly bool $isVip,
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

    public function isVip(): bool
    {
        return $this->isVip;
    }

    public function getLabel(): string
    {
        return "client \"$this->name\"";
    }
}
