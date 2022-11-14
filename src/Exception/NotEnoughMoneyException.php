<?php

namespace App\Exception;

use Exception;

class NotEnoughMoneyException extends Exception
{
    public function __construct(float $balance, float $price)
    {
        /*
         * using %s to avoid additional nums after coma
        */
        parent::__construct(sprintf('Total price %s is greater than your balance of %s', $price, $balance));
    }
}
