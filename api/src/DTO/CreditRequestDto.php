<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CreditRequestDto
{

    /**
     * @Assert\NotBlank(message="Car ID is required")
     * @Assert\Positive(message="Car ID must be positive")
     * @Assert\Type(type="integer", message="Car ID must be an integer")
     */

    private $carId;

    /**
     * @Assert\NotBlank(message="Credit program ID is required")
     * @Assert\Positive(message="Credit program ID must be positive")
     * @Assert\Type(type="integer", message="Credit program ID must be an integer")
     */
    private $creditProgramId;

    /**
     * @Assert\NotBlank(message="Initial payment is required")
     * @Assert\Positive(message="Initial payment must be positive")
     * @Assert\Type(type="numeric", message="Initial payment must be a number")
     */
    private $initialPayment;

    /**
     * @Assert\NotBlank(message="Loan term is required")
     * @Assert\Positive(message="Loan term must be positive")
     * @Assert\Type(type="integer", message="Loan term must be an integer")
     */
    private $loanTerm;

    public static function createFromArray(array $data): CreditRequestDTO
    {
        $dto                  = new self();
        $dto->carId           = $data['carId'];
        $dto->creditProgramId = $data['creditProgramId'];
        $dto->initialPayment  = $data['initialPayment'];
        $dto->loanTerm        = $data['loanTerm'];

        return $dto;
    }

    public function getCarId(): int
    {
        return $this->carId;
    }

    public function getCreditProgramId(): int
    {
        return $this->creditProgramId;
    }

    public function getInitialPayment(): float
    {
        return $this->initialPayment;
    }

    public function getLoanTerm(): int
    {
        return $this->loanTerm;
    }
}