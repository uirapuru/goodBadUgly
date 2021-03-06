<?php

declare(strict_types=1);

namespace App\Command;

use Prooph\EventStore\EventStore;
use Prooph\EventStore\Stream;
use Prooph\EventStore\StreamName;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateEventStreamCommand extends ContainerAwareCommand
{
    private $eventStore;

    public function __construct(string $name = null, EventStore $eventStore)
    {
        parent::__construct($name);
        $this->eventStore = $eventStore;
    }

    protected function configure()
    {
        $this->setName('event-store:event-stream:create')
            ->setDescription('Create event_stream.')
            ->setHelp('This command creates the event_stream');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->eventStore->create(new Stream(new StreamName('event_stream'), new \ArrayIterator([])));

        $output->writeln('<info>Event stream was created successfully.</info>');
    }
}
