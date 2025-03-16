<?php

namespace App\Entity;

use App\Repository\CreditProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditProgramRepository::class)]
class CreditProgram extends BaseEntity
{
    #[ORM\Column(type: 'float')]
    private $interestRate;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'float')]
    private float $initialPayment;

    #[ORM\Column(type: 'integer')]
    private int $loanTerm;

    /**
     * @ORM\OneToMany(targetEntity=CreditRequest::class, mappedBy="creditProgram", orphanRemoval=true)
     */
    private $creditRequests;

    public function __construct()
    {
        $this->creditRequests = new ArrayCollection();
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getInitialPayment(): float
    {
        return $this->initialPayment;
    }

    public function setInitialPayment(float $initialPayment): self
    {
        $this->initialPayment = $initialPayment;

        return $this;
    }

    public function getLoanTerm(): int
    {
        return $this->loanTerm;
    }

    public function setLoanTerm(int $loanTerm): self
    {
        $this->loanTerm = $loanTerm;
        
        return $this;
    }

    /**
     * @return Collection<int, CreditRequest>
     */
    public function getCreditRequests(): Collection
    {
        return $this->creditRequests;
    }

    public function addCreditRequest(CreditRequest $creditRequest): self
    {
        if (!$this->creditRequests->contains($creditRequest)) {
            $this->creditRequests[] = $creditRequest;
            $creditRequest->setCreditProgram($this);
        }

        return $this;
    }

    public function removeCreditRequest(CreditRequest $creditRequest): self
    {
        if ($this->creditRequests->removeElement($creditRequest)) {
            // set the owning side to null (unless already changed)
            if ($creditRequest->getCreditProgram() === $this) {
                $creditRequest->setCreditProgram(null);
            }
        }

        return $this;
    }
}
