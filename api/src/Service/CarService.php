<?php

namespace App\Service;

use App\DTO\CarDto;
use App\Repository\CarRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CarService
{

    private CarRepository $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }


    public function getAllCars(): array
    {
        $cars    = $this->carRepository->findAll();
        $carDtos = [];

        foreach ($cars as $car) {
            $carDtos[] = CarDto::createFromEntity($car);
        }

        return $carDtos;
    }


    public function getCarById(int $id): CarDto
    {
        $car = $this->carRepository->find($id);

        if (!$car) {
            throw new NotFoundHttpException('Car not found');
        }

        return CarDto::createFromEntity($car);
    }
} 