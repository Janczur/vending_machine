<?php
declare(strict_types=1);

namespace App\VendingMachine\UI\CLI\Command;

use App\VendingMachine\Core\Domain\CoinReturnerAlgorithm;
use App\VendingMachine\Core\Domain\ProductChooser;
use App\VendingMachine\Core\ModuleApi\VendingMachine;
use Exception;
use InvalidArgumentException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:vending-machine',
    description: 'Vending machine command'
)]
class VendingMachineCommand extends Command
{
    public function __construct(
        private readonly VendingMachine $vendingMachine
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Welcome to the vending machine!');
        $io->writeln('Insert coins and select a product');

        $coinsInput = $io->ask('Enter coins (separated by space)', null, function ($input) {
            return $this->validateCoinsInput($input);
        });

        $productCodeInput = $io->ask('Enter product code', 'A');

        try {
            $remainderInCoins = $this->vendingMachine->buyProduct($coinsInput, $productCodeInput);
        } catch (Exception $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        $io->success([
            sprintf('You just bought a product %s!', $productCodeInput),
            'Your total reminder is: ' . array_sum($remainderInCoins),
            'Returning in coins: ' . implode(' ', $remainderInCoins)
        ]);

        return Command::SUCCESS;
    }

    private function validateCoinsInput(mixed $input): array
    {
        if (empty($input)) {
            throw new InvalidArgumentException('You must provide at least one coin');
        }
        $coins = explode(' ', $input);
        foreach ($coins as $coin) {
            if (!is_numeric($coin) || $coin <= 0) {
                throw new InvalidArgumentException('Coins must be numeric and positive');
            }
        }
        return $coins;
    }
}
