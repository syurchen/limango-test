<?php

namespace App\Tests\Service;

use App\Model\Coin;
use App\Model\CoinCount;
use App\Service\CoinManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CoinManagerTest extends KernelTestCase
{
    /**
     * @dataProvider coinConversionDataProvider
     */
    public function testConvertToCoins(float $money, array $coinCounts): void
    {

        /**
         * @var CoinManager $coinManager
         */
        $coinManager = $this->getContainer()->get(CoinManager::class);

        $this->assertEquals($coinCounts, $coinManager->representInCoins($money));
    }

    public function coinConversionDataProvider(): array
    {
        return [
            [
                2,
                [
                    new CoinCount(Coin::TWO, 1),
                ]
            ],
            [
                5.02,
                [
                    new CoinCount(Coin::TWO, 2),
                    new CoinCount(Coin::ONE, 1),
                    new CoinCount(Coin::TWO_CENT, 1),
                ]
            ],
        ];
    }
}