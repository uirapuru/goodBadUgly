<?php

namespace Tests\Functional;

use App\Entity\Sentiment;
use App\Entity\User;
use App\Repository\UserRepository;
use Ramsey\Uuid\Uuid;

class AggregateTest extends WebTestCase
{
    /**
     * @test
     */
    public function testAdding()
    {
        $user = User::create(Uuid::uuid4());
        $user->add('test', Sentiment::positive());

        /** @var UserRepository $repository */
        $repository = $this->get(UserRepository::class);
        $repository->saveAggregateRoot($user);
    }
}