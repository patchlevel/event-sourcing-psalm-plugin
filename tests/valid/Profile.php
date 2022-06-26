<?php

namespace Tests\Valid;

use Patchlevel\EventSourcing\Aggregate\AggregateRoot;

class Profile extends AggregateRoot
{
    private string $id;
    private string $name;

    public static function create(string $id, string $name): self
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

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function aggregateRootId(): string
    {
        return $this->id;
    }
}