<?php

namespace App\Service;

final class PriceCalculator
{
    public function discountRate(float $subtotal, bool $isVip): float
    {
        $discount = 0.0;

        if ($subtotal > 100.0) {
            $discount += 0.10;
        }

        if ($isVip) {
            $discount += 0.10;
        }

        return min($discount, 0.20);
    }

    /**
     * @return array{float, float, float}
     */
    public function calculate(float $subtotal, bool $isVip): array
    {
        $discount = $this->discountRate($subtotal, $isVip);

        $shipping = $subtotal < 50.0 ? 5.0 : 0.0;

        $total = $subtotal * (1.0 - $discount) + $shipping;

        return [$total, $discount, $shipping];
    }
}
