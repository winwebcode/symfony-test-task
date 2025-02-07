<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CarController extends AbstractController
{

    /**
     * @Route("/api/v1/cars", name="api_cars", methods={"GET"})
     */
    public function list(CarRepository $carRepository): JsonResponse
    {
        $cars = $carRepository->findAll();

        foreach ($cars as $car) {
            $data[] = [
                'id'    => $car->getId(),
                'brand' => [
                    'id'   => $car->getBrand()->getId(),
                    'name' => $car->getBrand()->getName(),
                ],
                'photo' => $car->getPhoto(),
                'price' => $car->getPrice(),
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/api/v1/cars/{id}", name="api_show_car", methods={"GET"})
     */
    public function show(int $id, CarRepository $carRepository): JsonResponse
    {
        $car = $carRepository->find($id);

        if (!$car) {
            throw new NotFoundHttpException('Car not found');
        }

        $data = [
            'id'    => $car->getId(),
            'brand' => [
                'id'   => $car->getBrand()->getId(),
                'name' => $car->getBrand()->getName(),
            ],
            'model' => [
                'id'   => $car->getModel()->getId(),
                'name' => $car->getModel()->getName(),
            ],
            'photo' => $car->getPhoto(),
            'price' => $car->getPrice(),
        ];

        return new JsonResponse($data);
    }
}
