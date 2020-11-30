<?php

declare(strict_types=1);

namespace App\Listener;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\Persistence\Mapping\ClassMetadata;

class MappingListener
{
    public const DEFAULT = 'DEFAULT';
    public const SHARED = 'ballersb_events';

    /**
     * @var string
     */
    private $app;

    /**
     * @param string $app
     */
    public function __construct(string $app)
    {
        $this->app = $app;
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        /** @var ClassMetadata $classMetadata */
        $classMetadata = $eventArgs->getClassMetadata();

        if ($this->app === self::DEFAULT) {
            return;
        }

        $classMetadata->table['schema'] = $this->app;
    }
}