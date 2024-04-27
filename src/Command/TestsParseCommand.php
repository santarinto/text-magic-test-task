<?php

namespace App\Command;

use App\Service\LinesParserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:tests-parse',
    description: 'Simple parse file data/tests.txt for expression and result.',
)]
class TestsParseCommand extends Command
{
    public function __construct(
        private readonly LinesParserService $linesParserService
    ) {
        parent::__construct();
    }

    protected function configure(): void {}

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $io = new SymfonyStyle($input, $output);

        $content = file_get_contents(__DIR__ . '/../../data/tests.txt');
        $blocks = explode("\n\n\n", $content);
        $countBlocks = count($blocks);

        for ($i = 0; $i < $countBlocks; $i++) {
            $taskNumber = $i + 1;
            $io->writeln("\nBlock $taskNumber:");

            $dto = $this->linesParserService->parse(explode("\n", $blocks[$i]));

            $io->writeln("\t\tExpression: {$dto->getExpression()}");

            $countResults = count($dto->getResults());
            for ($j = 0; $j < $countResults; $j++) {
                $resultNumber = $j + 1;

                $io->writeln("\t\tresult[{$resultNumber}]: {$dto->getResults()[$j]}");
            }

            $io->writeln("\t\tCompiled answer: {$dto->getCompiledAnswer()}");
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
