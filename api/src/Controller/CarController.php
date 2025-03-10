<?php

namespace App\Controller;

use OpenApi\Annotations as OA;
use App\Service\CarService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CarController extends AbstractController
{


    /**
     * Get list of all cars
     *
     * @Route("/api/v1/cars", name="api_cars", methods={"GET"})
     *
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Page number",
     *     @OA\Schema(type="integer", default=1)
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns list of cars",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="brand", type="string", example="BMW"),
     *             @OA\Property(property="model", type="string", example="X5"),
     *             @OA\Property(property="price", type="number", example=4500000),
     *             @OA\Property(property="photo", type="string", example="https://example.com/photo.jpg")
     *         )
     *     )
     * )
     */
    public function list(CarService $carService, SerializerInterface $serializer): JsonResponse
    {
        $carDtos = $carService->getAllCars();
        $json    = $serializer->serialize($carDtos, 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /**
     * Get car by ID
     *
     * @Route("/api/v1/cars/{id}", name="api_show_car", methods={"GET"})
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID of car to return",
     *     @OA\Schema(type="integer")
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Car details",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", example=1),
     *         @OA\Property(property="brand", type="string", example="BMW"),
     *         @OA\Property(property="model", type="string", example="X5"),
     *         @OA\Property(property="price", type="number", example=4500000),
     *         @OA\Property(property="photo", type="string", example="https://example.com/photo.jpg")
     *     )
     * )
     * @OA\Response(
     *     response=404,
     *     description="Car not found",
     *     @OA\JsonContent(
     *         @OA\Property(property="error", type="string", example="Car not found")
     *     )
     * )
     */
    public function show(int $id, CarService $carService, SerializerInterface $serializer): JsonResponse
    {
        try {
            $carDto = $carService->getCarById($id);
            $json   = $serializer->serialize($carDto, 'json');

            return new JsonResponse($json, Response::HTTP_OK, [], true);

        } catch (NotFoundHttpException $e) {

            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
