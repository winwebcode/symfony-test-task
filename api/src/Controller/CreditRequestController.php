<?php

namespace App\Controller;

use App\DTO\CreditRequestDto;
use App\Service\CreditRequestService;
use Exception;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreditRequestController extends AbstractController
{

    #[Route('/api/v1/credit/request', name: 'api_credit_request', methods: ['POST'])]
    #[OA\Post(
        path: '/api/v1/credit/request',
        summary: 'Create new credit request',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['carId', 'initialPayment', 'loanTerm', 'creditProgramId'],
                properties: [
                    new OA\Property(property: 'carId', type: 'integer', example: 1),
                    new OA\Property(property: 'initialPayment', type: 'number', example: 900000),
                    new OA\Property(property: 'loanTerm', type: 'integer', example: 36),
                    new OA\Property(property: 'creditProgramId', type: 'integer', example: 1),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Credit request created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true)
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Invalid input',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false)
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Car or credit program not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'error', type: 'string', example: 'Car not found')
                    ]
                )
            )
        ]
    )]
    public function create(Request $request, CreditRequestService $creditRequestService): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $dto  = CreditRequestDto::createFromArray($data);
            $creditRequestService->validate($dto);
            $creditRequestService->createRequest($dto);

            return new JsonResponse(['success' => true], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return new JsonResponse(['success' => false, 'error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
