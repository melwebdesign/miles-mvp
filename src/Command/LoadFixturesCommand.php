<?php

namespace App\Command;

use App\Service\Maintenance\Maintenance;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-fixtures',
    description: 'Add a short description for your command',
)]
final class LoadFixturesCommand extends Command
{
    public function __construct(private Maintenance $maintenance)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $result = $this->maintenance->loadFixtures();
        if (true === $result) {
            $io->success('Fixtures of Vehicles have been loaded');

            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }
}
