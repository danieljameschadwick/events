<?php

declare(strict_types=1);

namespace App\Entity\Payment;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class CurrencyCode extends AbstractEnumType
{
    public const GBP = 'GBP';

    protected static $choices = [
        self::GBP => self::GBP
    ];

    /**
     * @param string $handle
     *
     * @return self
     */
    public static function createFromHandle(string $handle): self
    {
        return new self::$choices($handle);
    }

    /**
     * @return string
     */
    public static function gbp(): string
    {
        return self::GBP;
    }

    /**
     * @return bool
     */
    public function isGBP(): bool
    {
        return $this->getName() === self::GBP;
    }
}