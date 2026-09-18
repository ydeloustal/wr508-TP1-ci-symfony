<?php

namespace App\Service;

final class InputSanitizer
{
    public function escape(string $input): string
    {
        return htmlspecialchars($input, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public function isStrongPassword(string $password): bool
    {
        return strlen($password) >= 8
            && 1 === preg_match('/[a-z]/', $password)
            && 1 === preg_match('/[A-Z]/', $password)
            && 1 === preg_match('/[0-9]/', $password)
            && 1 === preg_match('/[^a-zA-Z0-9]/', $password);
    }

    /**
     * @return non-empty-string
     */
    public function sanitizeProductName(string $rawName): string
    {
        $clean = trim(strip_tags($rawName));

        if ('' === $clean) {
            throw new \InvalidArgumentException('Le nom du produit ne peut pas être vide.');
        }

        return $clean;
    }
}
