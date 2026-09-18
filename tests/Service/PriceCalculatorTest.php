<?php

namespace App\Tests\Service;

use App\Service\PriceCalculator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PriceCalculatorTest extends TestCase
{
    #[Test]
    public function pasDeRemiseSousCentEuros(): void
    {
        $calc = new PriceCalculator();
        $this->assertSame([99.0, 0.0, 0.0], $calc->calculate(99.0, false));
    }

    #[Test]
    public function dixPourcentAuDelaDeCentEuros(): void
    {
        $calc = new PriceCalculator();
        $this->assertSame([225.0, 0.10, 0.0], $calc->calculate(250.0, false));
    }

    #[Test]
    public function dixPourcentPourUnMembreVip(): void
    {
        $calc = new PriceCalculator();
        $this->assertSame([90.0, 0.10, 0.0], $calc->calculate(100.0, true));
    }

    #[Test]
    public function laRemiseNeDepasseJamaisVingtPourcent(): void
    {
        $calc = new PriceCalculator();
        $this->assertSame([200.0, 0.20, 0.0], $calc->calculate(250.0, true));
    }

    #[Test]
    public function fraisDePortPourUnPetitPanier(): void
    {
        $calc = new PriceCalculator();
        $this->assertSame([45.0, 0.0, 5.0], $calc->calculate(40.0, false));
    }

    #[Test]
    public function leTauxDeRemiseSeul(): void
    {
        $calc = new PriceCalculator();
        $this->assertSame(0.10, $calc->discountRate(250.0, false));
    }
}
