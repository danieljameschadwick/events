<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Core\Feature;
use App\Traits\EntityManagerTrait;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GlobalExtension extends AbstractExtension
{
    use EntityManagerTrait;

    public function getFunctions(): array
    {
        return [
            new TwigFunction('isFeatureEnabled', [$this, 'isFeatureEnabled']),
        ];
    }

    /**
     * @param string $handle
     *
     * @return bool
     */
    public function isFeatureEnabled(string $handle): bool
    {
        $feature = $this->getManager()
            ->getRepository(Feature::class)
            ->getFeatureByHandle($handle);

        return $feature->isActive();
    }
}
