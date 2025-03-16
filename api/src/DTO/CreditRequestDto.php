<?php

namespace App\DTO;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(
    schema: 'CreditRequestDto',
    description: 'Credit request data transfer object'
)]
readonly class CreditRequestDto
{

    #[OA\Property(description: 'Car ID', type: 'integer', example: 1)]
    #[Assert\NotBlank(message: 'Car ID is required')]
    #[Assert\Positive(message: 'Car ID must be positive')]
    #[Assert\Type(type: 'integer', message: 'Car ID must be an integer')]
    private int $carId;

    #[OA\Property(description: 'Credit program ID', type: 'integer', example: 1)]
    #[Assert\NotBlank(message: 'Credit program ID is required')]
    #[Assert\Positive(message: 'Credit program ID must be positive')]
    #[Assert\Type(type: 'integer', message: 'Credit program ID must be an integer')]
    private int $creditProgramId;

    #[OA\Property(description: 'Initial payment amount', type: 'number', format: 'float', example: 500000.00)]
    #[Assert\NotBlank(message: 'Initial payment is required')]
    #[Assert\Positive(message: 'Initial payment must be positive')]
    #[Assert\Type(type: 'float', message: 'Initial payment must be a number')]
    private float $initialPayment;

    #[OA\Property(description: 'Loan term in months', type: 'integer', example: 36)]
    #[Assert\NotBlank(message: 'Loan term is required')]
    #[Assert\Positive(message: 'Loan term must be positive')]
    #[Assert\Type(type: 'integer', message: 'Loan term must be an integer')]
    private int $loanTerm;

    public static function createFromArray(array $data): self
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