<?php

namespace Patchlevel\EventSourcingPsalmPlugin\Tests\Valid;

use Patchlevel\EventSourcing\Aggregate\BasicChildAggregate;
use Patchlevel\EventSourcing\Aggregate\Uuid;

class PersonalInformation extends BasicChildAggregate
{
    private Uuid $id;
    private string $name;

    public static function create(Uuid $id, string $name): self
    {
        $self = new self();

        $self->recordThat(new ProfileCreated($id, $name));

        return $self;
    }

    protected function applyProfileCreated(ProfileCreated $event): void
    {
        $this->id = $event->id;
        $this->name = $event->name;
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}