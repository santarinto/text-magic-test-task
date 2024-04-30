<?php

namespace App\EventListener;

use App\Entity\TestAttempt;
use App\Event\AnswerValidationSuccessEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: AnswerValidationSuccessEvent::class)]
final readonly class AnswerValidationSuccessEventListener
{
    public function __construct(
        private LoggerInterface        $logger,
        private EntityManagerInterface $entityManager,
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

        $this->entityManager->wrapInTransaction(fn() => $this
            ->entityManager
            ->persist((new TestAttempt())
                ->setExpression($expression)
                ->setResults($results)
                ->setCompiledAnswer($compiledAnswer)));
    }
}