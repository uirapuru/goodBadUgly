<?php

namespace App\Entity;

use MyCLabs\Enum\Enum;

class Sentiment extends Enum
{
    private const POSITIVE = 'positive';
    private const NEUTRAL = 'neutral';
    private const NEGATIVE = 'negative';
}