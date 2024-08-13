<?php

namespace Patchlevel\EventSourcingPsalmPlugin\Tests\Valid;

use Patchlevel\EventSourcing\Aggregate\AggregateRootId;
use Patchlevel\EventSourcing\Attribute\Subscribe;
use Patchlevel\EventSourcing\Message\Message;

class ProfileProjection
{
    #[Subscribe(ProfileCreated::class)]
    public function handleProfileCreated(Message $message): void
    {
        $event = $message->event();

        echo $event->name;
    }

    #[Subscribe(ProfileCreated::class)]
    #[Subscribe(NameChanged::class)]
    public function handleMultiple(Message $message): void
    {
        $event = $message->event();

        echo $event->name;
    }

    #[Subscribe(NameChanged::class)]
    public function handleArgumentResolver(NameChanged $event, AggregateRootId $id): void
    {
        echo $event->name;
    }
}