<?php

namespace App\Command;

use App\Service\FuzzyLogicExpressionSolverService;
use App\Service\LinesParserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:tests-run',
    description: 'Run tests from data/tests.txt.',
)]
class TestsRunCommand extends Command
{
    public function __construct(
        private readonly string                            $testsFilePath,
        private readonly LinesParserService                $linesParserService,
        private readonly FuzzyLogicExpressionSolverService $fuzzyLogicExpressionSolverService
    ) {
        parent::__construct();
    }

    protected function configure(): void {}

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $io = new SymfonyStyle($input, $output);
        $content = file_get_contents(__DIR__ . '/../../' . $this->testsFilePath);
        $blocks = explode("\n\n\n", $content);
        $countBlocks = count($blocks);

        for ($i = 0; $i < $countBlocks; $i++) {
            $taskNumber = $i + 1;
            $io->writeln("\nTask $taskNumber:");

            $dto = $this->linesParserService->parse(explode("\n", $blocks[$i]));

            $executedResult = $this
                ->fuzzyLogicExpressionSolverService
                ->solve($dto->getExpression(), $dto->getResults());

            $io->writeln("\t\tExpression: {$dto->getExpression()}");
            $io->writeln("\t\tCompiled answer: {$dto->getCompiledAnswer()}");

            if ($executedResult === $dto->getCompiledAnswer()) {
                $io->success('Result is correct!');
            } else {
                $io->error('Result is incorrect!');
            }
        }

        $io->success('Complete!');

        return Command::SUCCESS;
    }
}
