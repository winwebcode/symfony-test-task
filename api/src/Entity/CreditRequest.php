<?php

namespace App\Entity;

use App\Repository\CreditRequestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CreditRequestRepository::class)
 */
class CreditRequest extends BaseEntity
{

    /**
     * @ORM\ManyToOne(targetEntity=Car::class, inversedBy="creditRequests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $car;

    /**
     * @ORM\ManyToOne(targetEntity=CreditProgram::class, inversedBy="creditRequests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creditProgram;

    /**
     * @ORM\Column(type="float")
     */
    private $initialPayment;

    /**
     * @ORM\Column(type="integer")
     */
    private $loanTerm;

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getCreditProgram(): ?CreditProgram
    {
        return $this->creditProgram;
    }

    public function setCreditProgram(?CreditProgram $creditProgram): self
    {
        $this->creditProgram = $creditProgram;

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
