<?php

namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/store')]
final class StoreController
{
    /**
     * @return array<string, number>
     */
    #[Route('/sales')]
    public function storeSales(): array
    {
        $featured = [
            'lectures' => 12,
            'likes' => 3,
        ];

        return $featured;
    }
}
