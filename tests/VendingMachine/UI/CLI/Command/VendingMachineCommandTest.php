<?php

namespace App\Tests\VendingMachine\UI\CLI\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class VendingMachineCommandTest extends KernelTestCase
{
    public function testVendingMachineCommand(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = $application->find('app:vending-machine');
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['1 2 5 10 20 50 100', 'A']);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('You just bought a product A!', $output);
        $this->assertStringContainsString('Your total reminder is: 93', $output);
        $this->assertStringContainsString('Returning in coins: 50 20 20 2 1', $output);
    }

    public function testItDisplayExceptionErrors(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = $application->find('app:vending-machine');
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['1 2', 'A']);
        $commandTester->execute([]);


        $output = $commandTester->getDisplay();
        $this->assertStringContainsString(
            'Not enough money to buy the product. You have 3 cents and the product costs 95 cents. Please insert more coins.',
            $output
        );
    }
}
