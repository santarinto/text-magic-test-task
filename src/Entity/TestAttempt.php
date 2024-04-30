<?php

namespace App\Entity;

use App\Repository\TestAttemptRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestAttemptRepository::class)]
#[ORM\Table(name: "test_attempts")]
#[ORM\HasLifecycleCallbacks]
class TestAttempt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "datetime", nullable: false)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: "string", length: 128, nullable: false)]
    private ?string $expression = null;

    #[ORM\Column(type: "jsonb", nullable: true)]
    private ?array $results = null;

    #[ORM\Column(type: "string", length: 1024, nullable: false)]
    private ?string $compiledAnswer = null;

    #[ORM\PrePersist]
    public function onPrePersist(): void {
        if (is_null($this->createdAt)) {
            $this->createdAt = new DateTime();
        }
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface {
        return $this->createdAt;
    }

    public function getExpression(): ?string {
        return $this->expression;
    }

    public function setExpression(string $expression): self {
        $this->expression = $expression;
        return $this;
    }

    public function getResults(): ?array {
        return $this->results;
    }

    public function setResults(array $results): self {
        $this->results = $results;
        return $this;
    }

    public function getCompiledAnswer(): ?string {
        return $this->compiledAnswer;
    }

    public function setCompiledAnswer(string $compiledAnswer): self {
        $this->compiledAnswer = $compiledAnswer;
        return $this;
    }
}
