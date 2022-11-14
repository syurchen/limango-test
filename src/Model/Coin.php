<?php

namespace App\Model;

enum Coin
{
    case CENT;
    case TWO_CENT;
    case FIVE_CENT;
    case TEN_CENT;
    case TWENTY_CENT;
    case HALF;
    case ONE;
    case TWO;

    public function getValue(): float
    {
        return array_search($this, self::getValues());
    }

    public static function tryFrom(float $value): ?self
    {
        return self::getValues()[$value] ?? null;
    }

    private static function getValues(): array
    {
        return [
            '0.01' => self::CENT,
            '0.02' => self::TWO_CENT,
            '0.05' => self::FIVE_CENT,
            '0.1' => self::TEN_CENT,
            '0.2' => self::TWENTY_CENT,
            '0.5' => self::HALF,
            1 => self::ONE,
            2 => self::TWO,
        ];
    }
}
