<?php

namespace App\Entity;

use DateTime;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Act
{
    /** @var UuidInterface */
    protected $id;

    /** @var Sentiment */
    protected $sentiment;

    /** @var string */
    protected $description;

    /** @var DateTime */
    protected $createdAt;

    public function __construct(UuidInterface $id, Sentiment $sentiment, string $description, DateTime $createdAt)
    {
        $this->id = $id;
        $this->sentiment = $sentiment;
        $this->description = $description;
        $this->createdAt = $createdAt;
    }

    public static function fromTemplate(Template $template) : self
    {
        return new self(Uuid::uuid4(), $template->sentiment(), $template->description(), new DateTime("now"));
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function sentiment(): Sentiment
    {
        return $this->sentiment;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }
}