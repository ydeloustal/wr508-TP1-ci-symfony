<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\Routing\Attribute\Route;

final class WelcomeController
{
    /**
     * @return array<string, string>
     */
    #[Route('/welcome', name: 'app_welcome')]
    #[Template('welcome/index.html.twig')]
    public function __invoke(): array
    {
        return [
            'application' => 'WR508D',
        ];
    }
}
