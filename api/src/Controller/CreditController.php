<?php

namespace App\Controller;

use App\DTO\CreditCalculateDto;
use App\Service\CreditService;
use Exception;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use InvalidArgumentException;

class CreditController extends AbstractController
{

    #[OA\Parameter(
        name: 'price',
        description: 'Car price',
        in: 'query',
        required: true,
        schema: new OA\Schema(type: 'number', format: 'float', example: 4500000.00)
    )]
    #[OA\Parameter(
        name: 'initialPayment',
        description: 'Initial payment amount',
        in: 'query',
        required: true,
        schema: new OA\Schema(type: 'number', format: 'float', example: 900000.00)
    )]
    #[OA\Parameter(
        name: 'loanTerm',
        description: 'Loan term in months',
        in: 'query',
        required: true,
        schema: new OA\Schema(type: 'integer', example: 36)
    )]
    #[OA\Parameter(
        name: 'monthlyLoanPayment',
        description: 'Desired monthly payment',
        in: 'query',
        required: true,
        schema: new OA\Schema(type: 'number', format: 'float', example: 50000.00)
    )]
    #[OA\Response(
        response: 200,
        description: 'Credit calculation results',
        content: new OA\JsonContent(properties: [
            new OA\Property(property: 'programId', type: 'integer', example: 1),
            new OA\Property(property: 'interestRate', type: 'number', format: 'float', example: 10.5),
            new OA\Property(property: 'monthlyPayment', type: 'number', format: 'float', example: 52000.00),
            new OA\Property(property: 'title', type: 'string', example: 'Standard Credit Program')
        ])
    )]
    #[Route('/api/v1/credit/calculate', name: 'api_credit_calculate', methods: ['GET'])]
    public function calculate(
        Request             $request,
        CreditService       $creditService,
        SerializerInterface $serializer
    ): JsonResponse {
        try {
            $dto = CreditCalculateDto::createFromRequest($request);
            $creditService->validate($dto);
            $result = $creditService->calculate($dto);

            return new JsonResponse($serializer->serialize($result, 'json'), Response::HTTP_OK, [], true);
        } catch (InvalidArgumentException $e) {

            return new JsonResponse(
                ['error' => 'Validation failed', 'details' => json_decode($e->getMessage(), true)],
                Response::HTTP_BAD_REQUEST
            );
        } catch (Exception $e) {

            return new JsonResponse(
                ['error' => 'Internal server error'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
