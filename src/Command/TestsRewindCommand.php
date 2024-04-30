<?php

namespace App\Command;

use App\Repository\TestAttemptRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:tests-rewind',
    description: 'Add a short description for your command',
)]
class TestsRewindCommand extends Command
{
    public function __construct(
        private readonly TestAttemptRepository $testAttemptRepository,
    ) {
        parent::__construct();
    }

    protected function configure(): void {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'ID Test');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $io = new SymfonyStyle($input, $output);

        $id = $input->getArgument('id');

        if (!is_numeric($id)) {
            $io->error('ID must be a number!');
            return Command::FAILURE;
        }

        $testAttempt = $this
            ->testAttemptRepository
            ->find($id);

        if (!$testAttempt) {
            $io->error('Test attempt not found!');
            return Command::FAILURE;
        }

        $io->horizontalTable(
            [
                'ID',
                'Created At',
                'Expression',
                'Results',
                'Compiled Answer',
            ],
            [
                [
                    $testAttempt->getId(),
                    $testAttempt->getCreatedAt()->format('Y-m-d H:i:s'),
                    $testAttempt->getExpression(),
                    json_encode($testAttempt->getResults()),
                    $testAttempt->getCompiledAnswer(),
                ]
            ]);

        $io->success('Complete!');

        return Command::SUCCESS;
    }
}
