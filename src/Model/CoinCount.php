<?php

namespace App\Model;

class CoinCount
{
    public function __construct(
        private readonly Coin $coin,
        private int           $count = 0
    )
    {
    }

    public function getCoin(): Coin
    {
        return $this->coin;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

}