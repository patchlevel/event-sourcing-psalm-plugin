<?php

namespace Tests\Valid;

use Patchlevel\EventSourcing\Attribute\Handle;
use Patchlevel\EventSourcing\EventBus\Message;
use Patchlevel\EventSourcing\Projection\Projector\Projector;

class ProfileProjectionUsingProjector implements Projector
{
    #[Handle(ProfileCreated::class)]
    public function handleProfileCreated(Message $message): void
    {
        $event = $message->event();

        echo $event->name;
    }

    #[Handle(ProfileCreated::class)]
    #[Handle(NameChanged::class)]
    public function handleMultiple(Message $message): void
    {
        $event = $message->event();

        echo $event->name;
    }
}