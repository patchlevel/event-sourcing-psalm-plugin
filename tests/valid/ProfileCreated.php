<?php

namespace Tests\Valid;

class ProfileCreated
{
    public function __construct(
        public readonly string $id,
        public readonly string $name
    ) {
    }
}