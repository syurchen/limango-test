<?php

namespace App\Service;

use App\Model\Coin;
use App\Model\CoinCount;
use ValueError;

class CoinManager
{
    /**
     * @return CoinCount[]
     */
    public function representInCoins(float $money): array
    {
        $result = [];

        foreach (array_reverse(Coin::cases()) as $coin) {
            if (null === $coinCountToAdd = $this->extractCoin($money, $coin)) {
                continue;
            }
            $result[] = $coinCountToAdd;

            if (0.0 === $money) {
                break;
            }

            if ($money < 0) {
                throw new ValueError('Money went below 0. This should not happen');
            }
        }

        return $result;
    }

    private function extractCoin(float &$money, Coin $coin): ?CoinCount
    {
        $count = intval($money / $coin->getValue());

        if (0 === $count) {
            return null;
        }

        /*
         * TODO add check if the vending machine has coins in stock
         */
        $money = round($money - $count * $coin->getValue(), 2);

        return new CoinCount($coin, $count);
    }
}
