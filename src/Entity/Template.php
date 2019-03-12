<?php

namespace App\Entity;

use Ramsey\Uuid\UuidInterface;

class Template
{
    /** @var UuidInterface */
    protected $id;

    /** @var string */
    protected $description;

    /** @var Sentiment */
    protected $sentiment;

    public function __construct(UuidInterface $id, string $description, Sentiment $sentiment)
    {
        $this->id = $id;
        $this->description = $description;
        $this->sentiment = $sentiment;
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function sentiment(): Sentiment
    {
        return $this->sentiment;
    }
}