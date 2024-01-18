<?php

namespace Patchlevel\EventSourcingPsalmPlugin\Tests\Valid;

use Patchlevel\EventSourcing\Aggregate\Uuid;
use Patchlevel\EventSourcing\Serializer\Normalizer\IdNormalizer;

class ProfileCreated
{
    public function __construct(
        #[IdNormalizer(Uuid::class)]
        public readonly Uuid $id,
        public readonly string $name
    ) {
    }
}