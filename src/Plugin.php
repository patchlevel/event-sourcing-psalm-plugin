<?php

declare(strict_types=1);

namespace Patchlevel\EventSourcingPsalmPlugin;

use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;
use SimpleXMLElement;

use function class_exists;

class Plugin implements PluginEntryPointInterface
{
    public function __invoke(RegistrationInterface $registration, ?SimpleXMLElement $config = null): void
    {
        class_exists(SuppressAggregateRoot::class);
        $registration->registerHooksFromClass(SuppressAggregateRoot::class);

        class_exists(ProjectionHandleProvider::class);
        $registration->registerHooksFromClass(ProjectionHandleProvider::class);
    }
}
