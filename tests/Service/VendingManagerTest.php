<?php

namespace App\Tests\Service;

use App\Exception\NotEnoughMoneyException;
use App\Service\VendingManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VendingManagerTest extends KernelTestCase
{
    /**
     * @dataProvider successfulPurchaseDataProvider
     */
    public function testPurchase(float $balance, int $count, float $change): void
    {
        /**
         * @var VendingManager $vendingManager
         */
        $vendingManager = $this->getContainer()->get(VendingManager::class);
        $this->assertEquals($change, $vendingManager->purchase($count, $balance));
    }

    /**
     * @dataProvider failedPurchaseDataProvider
     */
    public function testFaildedPurchase(float $balance, int $count): void
    {
        /**
         * @var VendingManager $vendingManager
         */
        $vendingManager = $this->getContainer()->get(VendingManager::class);
        $this->expectException(NotEnoughMoneyException::class);
        $vendingManager->purchase($count, $balance);
    }

    public function successfulPurchaseDataProvider(): array
    {
        return [
            [
                50, 5, 25.05,
            ],
            [
                10, 2, 0.02,
            ],
        ];
    }

    public function failedPurchaseDataProvider(): array
    {
        return [
            [
                3, 5,
            ],
            [
                4, 2,
            ],
        ];
    }
}
