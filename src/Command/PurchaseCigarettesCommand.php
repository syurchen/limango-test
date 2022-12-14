<?php

namespace App\Command;

use App\Exception\NotEnoughMoneyException;
use App\Model\CoinCount;
use App\Service\CoinManager;
use App\Service\VendingManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'purchase-cigarettes',
    description: 'Purchases cigarettes and returns change in coins',
)]
class PurchaseCigarettesCommand extends Command
{
    public function __construct(
        private VendingManager $vendingManager,
        private CoinManager $coinManager,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('count', InputArgument::REQUIRED, 'Amount of cigarettes to purchase')
            ->addArgument('money', InputArgument::REQUIRED, 'Amount of money to input')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $cigCount = (int) $input->getArgument('count');
        $moneyBalance = (float) $input->getArgument('money');

        if ($cigCount <= 0 || $moneyBalance <= 0) {
            $io->error('Money and cigarette count should greater than zero');

            return Command::FAILURE;
        }

        try {
            $change = $this->vendingManager->purchase($cigCount, $moneyBalance);
        } catch (NotEnoughMoneyException $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }

        $io->success(
            sprintf(
                'You bought %d packs of cigarettes for -%s€, each for -%s€',
                $cigCount,
                $moneyBalance - $change,
                VendingManager::PACK_PRICE
            )
        );
        $changeInCoins = $this->coinManager->representInCoins($change);
        $this->buildChangeTable($changeInCoins, $output);

        return Command::SUCCESS;
    }

    /**
     * @param CoinCount[] $changeInCoins
     */
    private function buildChangeTable(array $changeInCoins, OutputInterface $output): void
    {
        $table = new Table($output);
        $table->setHeaders([
            'Coins',
            'Count',
        ]);
        foreach ($changeInCoins as $coinCount) {
            $table->addRow([
                $coinCount->getCoin()->getValue(),
                $coinCount->getCount(),
            ]);
        }

        $table->render();
    }
}
