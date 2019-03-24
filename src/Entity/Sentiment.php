<?php

namespace App\Entity;

use MyCLabs\Enum\Enum;

/**
 * Class Sentiment
 * @package App\Entity
 *
 * @method Sentiment positive
 * @method Sentiment neutral
 * @method Sentiment negative
 */
class Sentiment extends Enum
{
    private const positive = 'positive';
    private const neutral = 'neutral';
    private const negative = 'negative';
}