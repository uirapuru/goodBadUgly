<?php

namespace App\Entity;

use App\Event\ActivityAdded;
use App\Event\UserCreated;
use DateTime;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class User extends AggregateRoot
{
    const DATE_FORMAT = 'Y-m-d H:i:s';

    protected $callbacks = [
        UserCreated::class => 'whenUserCreated',
        ActivityAdded::class => 'whenActivityAdded'
    ];

    /** @var UuidInterface */
    protected $id;

    protected $activities = [];

    public static function create(UuidInterface $id): self
    {
        $user = new self();
        $event = UserCreated::occur($id->toString(), ['id' => $id->toString()]);
        $user->recordThat($event);

        return $user;
    }

    public function add(string $description, Sentiment $sentiment)
    {
        $this->recordThat(ActivityAdded::occur($this->aggregateId(), [
            'description' => $description,
            'sentiment' => $sentiment->getValue(),
            'createdAt' => (new DateTime())->format(self::DATE_FORMAT),
            'id' => Uuid::uuid4()->toString()
        ]));
    }

    protected function aggregateId(): string
    {
        return $this->id->toString();
    }

    protected function apply(AggregateChanged $event): void
    {
        $method = $this->callbacks[get_class($event)];
        $this->{$method}($event);
        $this->updatedAt = new DateTime("now");
    }

    private function whenUserCreated(UserCreated $event)
    {
        $this->id = Uuid::fromString($event->aggregateId());
    }

    private function whenActivityAdded(ActivityAdded $event)
    {
        $data = $event->payload();

        $this->activities[$data['id']] = new Act(
            Uuid::fromString($data['id']),
            forward_static_call([Sentiment::class, $data["sentiment"]]),
            $data['description'],
            new DateTime($data['createdAt'])
        );
    }
}