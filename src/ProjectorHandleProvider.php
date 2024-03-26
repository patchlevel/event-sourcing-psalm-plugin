<?php

declare(strict_types=1);

namespace Patchlevel\EventSourcingPsalmPlugin;

use Patchlevel\EventSourcing\Attribute\Handle;
use Patchlevel\EventSourcing\EventBus\Message;
use Patchlevel\EventSourcing\Projection\Projector\Projector;
use Psalm\Plugin\EventHandler\AfterClassLikeVisitInterface;
use Psalm\Plugin\EventHandler\Event\AfterClassLikeVisitEvent;
use Psalm\Storage\MethodStorage;
use Psalm\Type;
use Psalm\Type\Atomic\TNamedObject;

use function array_values;
use function in_array;

class ProjectorHandleProvider implements AfterClassLikeVisitInterface
{
    public static function afterClassLikeVisit(AfterClassLikeVisitEvent $event): void
    {
        $storage = $event->getStorage();

        if (
            !$storage->user_defined
            || $storage->is_interface
            || !in_array(Projector::class, $storage->direct_class_interfaces)
        ) {
            return;
        }

        foreach ($storage->methods as $method) {
            $events = self::handledEvents($method);

            if ($events === []) {
                continue;
            }

            $param = $method->params[0] ?? null;

            if (!$param) {
                continue;
            }

            $param->type = new Type\Union([
                new Type\Atomic\TGenericObject(Message::class, [
                    new Type\Union($events),
                ]),
            ]);
        }
    }

    /**
     * @return list<TNamedObject>
     */
    private static function handledEvents(MethodStorage $method): array
    {
        $events = [];

        foreach ($method->attributes as $attribute) {
            if ($attribute->fq_class_name !== Handle::class) {
                continue;
            }

            $arg = $attribute->args[0] ?? null;

            if (!$arg) {
                continue;
            }

            $type = $arg->type;

            if (!$type instanceof Type\Union) {
                continue;
            }

            $atomicType = self::firstAtomicType($type);

            if (!$atomicType instanceof Type\Atomic\TLiteralClassString) {
                continue;
            }

            $events[] = new TNamedObject($atomicType->value);
        }

        return $events;
    }

    private static function firstAtomicType(Type\Union $union): ?Type\Atomic
    {
        $types = array_values($union->getAtomicTypes());

        return $types[0] ?? null;
    }
}
