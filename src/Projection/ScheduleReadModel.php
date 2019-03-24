<?php

namespace App\Projection;


use App\Event\ActivityAdded;
use App\Event\UserCreated;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventStore\Projection\AbstractReadModel;

class ScheduleReadModel extends AbstractReadModel
{
    protected $callbacks = [
        UserCreated::class => 'whenUserCreated',
        ActivityAdded::class => 'whenActivityAdded'
    ];

    /** @var array */
    private $stack = [];

    /** @var Connection */
    protected $connection;

    /** @var EntityManagerInterface */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->connection = $em->getConnection();
    }

    public function init(): void
    {
        // TODO: Implement init() method.
    }

    public function isInitialized(): bool
    {
        // TODO: Implement isInitialized() method.
    }

    public function reset(): void
    {
        // TODO: Implement reset() method.
    }

    public function delete(): void
    {
        // TODO: Implement delete() method.
    }

    public function __invoke(AggregateChanged $event)
    {
        $this->stack($this->callbacks[get_class($event)], $event);
    }

    public function persist() : void
    {
        $this->connection->beginTransaction();

        foreach ($this->stack as list($operation, $args)) {
            $this->{$operation}(...$args);
        }

        $this->connection->commit();

        $this->stack = [];
    }

    private function whenUserCreated(UserCreated $event)
    {
        sleep();
    }

    private function whenActivityAdded(ActivityAdded $event)
    {
        sleep();
    }

}