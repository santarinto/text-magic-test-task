<?php

namespace App\Command;

use App\Repository\TestAttemptRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:tests-history',
    description: 'List history of test attempts from DB.',
)]
class TestsHistoryCommand extends Command
{
    public function __construct(
        private readonly TestAttemptRepository $testAttemptRepository,
    ) {
        parent::__construct();
    }

    protected function configure(): void {}

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $io = new SymfonyStyle($input, $output);

        $testAttempts = $this
            ->testAttemptRepository
            ->getLast20TestAttempts();

        $io->table(
            [
                'ID',
                'Created At',
                'Expression',
                'Results',
                'Compiled Answer'
            ],
            array_map(fn($testAttempt) => [
                $testAttempt->getId(),
                $testAttempt->getCreatedAt()->format('Y-m-d H:i:s'),
                $testAttempt->getExpression(),
                json_encode($testAttempt->getResults()),
                $testAttempt->getCompiledAnswer(),
            ], $testAttempts));

        $io->success('Complete!');

        return Command::SUCCESS;
    }
}
