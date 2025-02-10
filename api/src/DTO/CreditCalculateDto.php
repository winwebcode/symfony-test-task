<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreditCalculateDto
{

    /**
     * @Assert\NotBlank(message="Price is required")
     * @Assert\Positive(message="Price must be positive")
     * @Assert\Type(type="integer", message="Price must be an integer")
     *
     * @var int
     */
    private $price;

    /**
     * @Assert\NotBlank(message="Initial payment is required")
     * @Assert\Positive(message="Initial payment must be positive")
     * @Assert\Type(type="float", message="Initial payment must be number")
     *
     * @var float
     */
    private $initialPayment;

    /**
     * @Assert\NotBlank(message="Loan term is required")
     * @Assert\Positive(message="Loan term must be positive")
     * @Assert\Type(type="integer", message="Loan term must be an integer")
     *
     * @var int
     */
    private $loanTerm;

    /**
     * @Assert\NotBlank(message="Monthly loan payment is required")
     * @Assert\Type(type="float", message="Monthly loan payment must be a float")
     * @Assert\PositiveOrZero(message="Monthly loan payment must be positive or zero")
     *
     * @var float
     */
    private $monthlyLoanPayment;


    public static function createFromRequest(Request $request): self
    {
        $dto = new self();
        $dto->price = $request->query->getInt('price');
        //FILTER_FLAG_ALLOW_THOUSAND (allow symbol ',')
        $initialPayment     = filter_var($request->query->get('initialPayment'), FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
        $monthlyLoanPayment = filter_var($request->query->get('monthlyLoanPayment'), FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);

        // check that filter_var returned not false (i.e. validation was successful)
        if ($initialPayment !== false) {
            $dto->initialPayment = (float)$initialPayment;
        } else {
            $dto->initialPayment = 0.0;
        }

        if ($monthlyLoanPayment !== false) {
            $dto->monthlyLoanPayment = (float)$monthlyLoanPayment;
        } else {
            $dto->monthlyLoanPayment = 0.0;
        }

        $dto->loanTerm = $request->query->getInt('loanTerm');

        return $dto;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getInitialPayment(): float
    {
        return $this->initialPayment;
    }

    public function getLoanTerm(): int
    {
        return $this->loanTerm;
    }

    public function getMonthlyLoanPayment(): float
    {
        return $this->monthlyLoanPayment;
    }
}