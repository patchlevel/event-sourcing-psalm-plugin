<?php

namespace Patchlevel\EventSourcingPsalmPlugin\Tests\Valid;

use Patchlevel\EventSourcing\Attribute\Subscribe;
use Patchlevel\EventSourcing\EventBus\Message;

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
}