<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use App\DTO\CarDto;

class CarController extends AbstractController
{

    /**
     * @Route("/api/v1/cars", name="api_cars", methods={"GET"})
     */
    public function list(CarRepository $carRepository, SerializerInterface $serializer): JsonResponse
    {
        $cars    = $carRepository->findAll();
        $carDtos = [];

        foreach ($cars as $car) {
            $carDtos[] = CarDto::createFromEntity($car);
        }

        $json = $serializer->serialize($carDtos, 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/v1/cars/{id}", name="api_show_car", methods={"GET"})
     */
    public function show(int $id, CarRepository $carRepository, SerializerInterface $serializer): JsonResponse
    {
        $car = $carRepository->find($id);

        if (!$car) {
            throw new NotFoundHttpException('Car not found');
        }

        $carDto = CarDto::createFromEntity($car);
        $json   = $serializer->serialize($carDto, 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}
