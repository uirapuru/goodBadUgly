<?php
namespace Tests\Functional;

use Doctrine\ORM\EntityManagerInterface;
use Liip\FunctionalTestBundle\Test\WebTestCase as BaseWebTestCase;
use Prooph\EventStore\InMemoryEventStore;
use Prooph\EventStore\Stream;
use Prooph\EventStore\StreamName;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Tools\SchemaTool;

class WebTestCase extends BaseWebTestCase
{
    /** @var Client */
    protected $client;

    protected function setUp() : void
    {
        if($this->client === null) {
            $this->client = $this->createClient();
        }

        /** @var EntityManagerInterface $em */
        $em = $this->get('doctrine')->getManager();

        $metaData = $em->getMetadataFactory()->getAllMetadata();

        $tool = new SchemaTool($em);
        $tool->dropSchema($metaData);
        $tool->createSchema($metaData);

        if($this->has(InMemoryEventStore::class)) {
            $inMemoryEventStore = $this->get(InMemoryEventStore::class);

            $inMemoryEventStore->create(new Stream(new StreamName('event_stream'), new \ArrayIterator([])));
        }
    }

    public function get(string $service) // : object - readd when bamboo gets php72
    {
        return $this->client->getContainer()->get('test.service_container')->get($service);
    }


    public function getParameter(string $parameter) : string
    {
        return $this->client->getContainer()->get('test.service_container')->getParameter($parameter);
    }

    protected function assertJsonResponse(Response $response)
    {
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('Content-Type'));
    }

    private function has(string $service) : bool
    {
        return $this->client->getContainer()->get('test.service_container')->has($service);
    }
}