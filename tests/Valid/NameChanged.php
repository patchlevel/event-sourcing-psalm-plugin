<?php

namespace Patchlevel\EventSourcingPsalmPlugin\Tests\Valid;

final class NameChanged
{
    public function __construct(
        public readonly string $name
    ) {
    }
}