<?php

namespace App\Service;

use App\DTO\CreditCalculateDto;
use App\Repository\CreditProgramRepository;
use RuntimeException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreditService extends BaseService
{

    public function __construct(
        private readonly CreditProgramRepository $creditProgramRepository,
        ValidatorInterface              $validator
    ) {
        parent::__construct($validator);
    }

    public function calculate(CreditCalculateDTO $dto): array
    {
        $program = $this->creditProgramRepository->findSuitableProgram(
            $dto->getInitialPayment(),
            $dto->getLoanTerm(),
            $dto->getMonthlyLoanPayment()
        );

        if (!$program) {
            throw new RuntimeException('No suitable credit program found');
        }

        //Annuity payment
        $loanAmount          = $dto->getPrice() - $dto->getInitialPayment();
        $monthlyInterestRate = $program->getInterestRate() / 12 / 100;
        $monthlyPayment      = 0;

        if ($monthlyInterestRate > 0) {
            $monthlyPayment = $loanAmount * ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $dto->getLoanTerm()))
                / (pow(1 + $monthlyInterestRate, $dto->getLoanTerm()) - 1);
        }

        return [
            'programId'      => $program->getId(),
            'interestRate'   => $program->getInterestRate(),
            'monthlyPayment' => (int)round($monthlyPayment),
            'title'          => $program->getTitle(),
        ];
    }
}