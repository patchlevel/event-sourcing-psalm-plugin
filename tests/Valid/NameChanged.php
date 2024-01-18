<?php

namespace Patchlevel\EventSourcingPsalmPlugin\Tests\Valid;

class NameChanged
{
    public function __construct(
        public readonly string $name
    ) {
    }
}