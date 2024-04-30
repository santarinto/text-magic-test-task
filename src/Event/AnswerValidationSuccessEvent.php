<?php

namespace App\Event;

use App\Domain\Dto\TestAttemptDto;
use Symfony\Contracts\EventDispatcher\Event;

class AnswerValidationSuccessEvent extends Event
{
    private TestAttemptDto $calculatedDto;

    public function __construct(TestAttemptDto $calculatedDto) {
        $this->calculatedDto = $calculatedDto;
    }

    public function getCalculatedDto(): TestAttemptDto {
        return $this->calculatedDto;
    }

    public function setCalculatedDto(TestAttemptDto $calculatedDto): void {
        $this->calculatedDto = $calculatedDto;
    }
}