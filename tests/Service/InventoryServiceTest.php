<?php

namespace App\Tests\Service;

use App\Entity\Product;
use App\Service\InventoryService;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class InventoryServiceTest extends TestCase
{
    #[Test]
    public function laVenteDecroitLeStock(): void
    {
        $product = new Product(7, 'Carte graphique', 299.0, 10);
        $inventory = new InventoryService([$product]);

        $inventory->sell($product, 3);

        $this->assertSame(7, $inventory->stockOf($product));
    }

    #[Test]
    public function laVenteEstRefuseeSiStockInsuffisant(): void
    {
        $product = new Product(9, 'Casque audio', 89.0, 2);
        $inventory = new InventoryService([$product]);

        $this->expectException(\InvalidArgumentException::class);

        $inventory->sell($product, 5);
    }

    #[Test]
    public function laQuantiteNegativeEstRejetee(): void
    {
        $product = new Product(9, 'Casque audio', 89.0, 2);
        $inventory = new InventoryService([$product]);

        $this->expectException(\InvalidArgumentException::class);

        $inventory->sell($product, -2);
    }
}
