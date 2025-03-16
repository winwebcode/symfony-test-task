<?php

namespace App\Service;

use App\DTO\CreditRequestDto;
use App\Entity\CreditRequest;
use App\Repository\CarRepository;
use App\Repository\CreditProgramRepository;
use App\Repository\CreditRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreditRequestService extends BaseService
{

    public function __construct(
        EntityManagerInterface  $entityManager,
        CarRepository           $carRepository,
        CreditProgramRepository $creditProgramRepository,
        CreditRequestRepository $creditRequestRepository,
        ValidatorInterface      $validator
    ) {
        parent::__construct($validator);
        $this->entityManager           = $entityManager;
        $this->carRepository           = $carRepository;
        $this->creditProgramRepository = $creditProgramRepository;
        $this->creditRequestRepository = $creditRequestRepository;
    }

    public function createRequest(CreditRequestDTO $dto): CreditRequest
    {
        $car = $this->carRepository->find($dto->getCarId());

        if (!$car) {
            throw new Exception('Car not found');
        }

        $creditProgram = $this->creditProgramRepository->find($dto->getCreditProgramId());

        if (!$creditProgram) {
            throw new Exception('Credit program not found');
        }

        return $this->creditRequestRepository->createRequest(
            $car,
            $creditProgram,
            $dto->getInitialPayment(),
            $dto->getLoanTerm(),
        );
    }


}