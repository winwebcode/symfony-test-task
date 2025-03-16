<?php

namespace App\Controller;

use App\Service\CarService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

#[Route('/api/v1')]
class CarController extends AbstractController
{

    #[Route('/cars', name: 'api_cars', methods: ['GET'])]
    #[OA\Parameter(
        name: 'page',
        description: 'Page number',
        in: 'query',
        schema: new OA\Schema(type: 'integer', default: 1)
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns list of cars',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(properties: [
                new OA\Property(property: 'id', type: 'integer', example: 1),
                new OA\Property(property: 'brand', type: 'string', example: 'BMW'),
                new OA\Property(property: 'model', type: 'string', example: 'X5'),
                new OA\Property(property: 'price', type: 'number', example: 4500000),
                new OA\Property(property: 'photo', type: 'string', example: 'https://example.com/photo.jpg')
            ])
        )
    )]
    public function list(CarService $carService, SerializerInterface $serializer): JsonResponse
    {
        $carDtos = $carService->getAllCars();
        $json    = $serializer->serialize($carDtos, 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/cars/{id}', name: 'api_show_car', methods: ['GET'])]
    #[OA\Parameter(
        name: 'id',
        description: 'ID of car to return',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Car details',
        content: new OA\JsonContent(properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'brand', type: 'string', example: 'BMW'),
            new OA\Property(property: 'model', type: 'string', example: 'X5'),
            new OA\Property(property: 'price', type: 'number', example: 4500000),
            new OA\Property(property: 'photo', type: 'string', example: 'https://example.com/photo.jpg')
        ])
    )]
    #[OA\Response(
        response: 404,
        description: 'Car not found',
        content: new OA\JsonContent(properties: [
            new OA\Property(property: 'error', type: 'string', example: 'Car not found')
        ])
    )]
    public function show(int $id, CarService $carService, SerializerInterface $serializer): JsonResponse
    {
        try {
            $carDto = $carService->getCarById($id);
            $json   = $serializer->serialize($carDto, 'json');

            return new JsonResponse($json, Response::HTTP_OK, [], true);
        } catch (NotFoundHttpException $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
