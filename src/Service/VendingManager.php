<?php

namespace App\Service;

use App\Exception\NotEnoughMoneyException;

class VendingManager
{
    public const PACK_PRICE = 4.99;

    /**
     * @throws NotEnoughMoneyException
     */
    public function purchase(int $amount, float $balance): float
    {
        $totalPrice = $this->calculateTotalPrice($amount);
        $change = $balance - $totalPrice;
        if ($change < 0) {
            throw new NotEnoughMoneyException($balance, $totalPrice);
        }

        return $change;
    }

    private function calculateTotalPrice(int $amount): float
    {
        return $amount * self::PACK_PRICE;
    }

}