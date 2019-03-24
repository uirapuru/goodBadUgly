<?php

namespace App\Projection;


use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\Common\Messaging\Message;
use Prooph\EventStore\Projection\ReadModelProjector;

class SnapshotProjection implements ReadModelProjection
{
    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector->fromStream('event_stream')->whenAny(
            function ($state, Message $event): void {
                $readModel = $this->readModel();
                $readModel->stack('test', $event);
            }
        );

        return $projector;
    }
}