<?php

namespace App\Tests\Service;

use App\Service\InputSanitizer;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class InputSanitizerTest extends TestCase
{
    #[Test]
    public function lesBalisesSontEchappees(): void
    {
        $sanitizer = new InputSanitizer();
        $this->assertSame('&lt;script&gt;', $sanitizer->escape('<script>'));
    }

    #[Test]
    public function accepteUnMotDePasseFort(): void
    {
        $sanitizer = new InputSanitizer();
        $this->assertTrue($sanitizer->isStrongPassword('Mot2Passe!Robuste'));
    }

    #[Test]
    public function rejetteUnMotDePasseFaible(): void
    {
        $sanitizer = new InputSanitizer();
        $this->assertFalse($sanitizer->isStrongPassword('azerty'));
    }

    #[Test]
    public function rejetteLesNomsDeProduitsVides(): void
    {
        $sanitizer = new InputSanitizer();

        $this->expectException(\InvalidArgumentException::class);

        $sanitizer->sanitizeProductName('   ');
    }
}
