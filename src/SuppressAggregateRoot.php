<?php

declare(strict_types=1);

namespace Patchlevel\EventSourcingPsalmPlugin;

use Patchlevel\EventSourcing\Aggregate\AggregateRoot;
use Psalm\Plugin\EventHandler\AfterClassLikeVisitInterface;
use Psalm\Plugin\EventHandler\Event\AfterClassLikeVisitEvent;

class SuppressAggregateRoot implements AfterClassLikeVisitInterface
{
    public static function afterClassLikeVisit(AfterClassLikeVisitEvent $event): void
    {
        $storage = $event->getStorage();

        if (
            !$storage->user_defined
            || $storage->is_interface
            || $storage->parent_class !== AggregateRoot::class
        ) {
            return;
        }

        $storage->suppressed_issues[] = 'PropertyNotSetInConstructor';
    }
}
