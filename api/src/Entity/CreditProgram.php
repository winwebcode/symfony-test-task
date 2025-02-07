<?php

namespace App\Entity;

use App\Repository\CreditProgramRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CreditProgramRepository::class)
 */
class CreditProgram
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $interestRate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="float")
     */
    private $initialPayment;

    /**
     * @ORM\Column(type="integer")
     */
    private $loanTerm;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInterestRate(): ?float
    {
        return $this->interestRate;
    }

    public function setInterestRate(float $interestRate): self
    {
        $this->interestRate = $interestRate;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getInitialPayment(): ?float
    {
        return $this->initialPayment;
    }

    public function setInitialPayment(float $initialPayment): self
    {
        $this->initialPayment = $initialPayment;

        return $this;
    }

    public function getLoanTerm(): ?int
    {
        return $this->loanTerm;
    }

    public function setLoanTerm(int $loanTerm): self
    {
        $this->loanTerm = $loanTerm;

        return $this;
    }
}
