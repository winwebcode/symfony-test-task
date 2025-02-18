<?php

namespace App\Controller;

use App\DTO\CreditCalculateDto;
use App\Services\CreditService;
use Exception;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use InvalidArgumentException;

class CreditController extends AbstractController
{

    /**
     * Calculate credit parameters
     *
     * @Route("/api/v1/credit/calculate", name="api_credit_calculate", methods={"GET"})
     *
     * @OA\Parameter(
     *     name="price",
     *     in="query",
     *     required=true,
     *     description="Car price",
     *     @OA\Schema(type="number", format="float", example=4500000.00)
     * )
     * @OA\Parameter(
     *     name="initialPayment",
     *     in="query",
     *     required=true,
     *     description="Initial payment amount",
     *     @OA\Schema(type="number", format="float", example=900000.00)
     * )
     * @OA\Parameter(
     *     name="loanTerm",
     *     in="query",
     *     required=true,
     *     description="Loan term in months",
     *     @OA\Schema(type="integer", example=36)
     * )
     * @OA\Parameter(
     *     name="monthlyLoanPayment",
     *     in="query",
     *     required=true,
     *     description="Desired monthly payment",
     *     @OA\Schema(type="number", format="float", example=50000.00)
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Credit calculation results",
     *     @OA\JsonContent(
     *         @OA\Property(property="programId", type="integer", example=1),
     *         @OA\Property(property="interestRate", type="number", format="float", example=10.5),
     *         @OA\Property(property="monthlyPayment", type="number", format="float", example=52000.00),
     *         @OA\Property(property="title", type="string", example="Standard Credit Program")
     *     )
     * )
     */
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
