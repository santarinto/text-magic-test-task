<?php

namespace App\EventListener;

use App\Event\AnswerValidationSuccessEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: AnswerValidationSuccessEvent::class)]
final readonly class AnswerValidationSuccessEventListener
{
    public function __construct(
        private LoggerInterface $logger
    ) {}

    public function __invoke(AnswerValidationSuccessEvent $event): void {
        $calculatedDto = $event->getCalculatedDto();
        $expression = $calculatedDto->getExpression();
        $results = $calculatedDto->getResults();
        $compiledAnswer = $calculatedDto->getCompiledAnswer();

        $this->logger->info('AnswerValidationSuccessEvent was dispatched', [
            'expression' => $expression,
            'results' => $results,
            'compiledAnswer' => $compiledAnswer
        ]);
    }
}