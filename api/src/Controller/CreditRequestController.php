<?php

namespace App\Controller;

use App\DTO\CreditRequestDto;
use App\Services\CreditRequestService;
use Exception;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreditRequestController extends AbstractController
{

    /**
     * Create new credit request
     *
     * @Route("/api/v1/credit/request", name="api_credit_request", methods={"POST"})
     *
     * @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *         required={"carId", "creditProgramId", "initialPayment", "loanTerm"},
     *         @OA\Property(property="carId", type="integer", example=1),
     *         @OA\Property(property="creditProgramId", type="integer", example=1),
     *         @OA\Property(property="initialPayment", type="number", example=900000),
     *         @OA\Property(property="loanTerm", type="integer", example=36)
     *     )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Credit request created successfully",
     *     @OA\JsonContent(
     *         @OA\Property(property="success", type="boolean", example=true)
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Invalid input",
     *     @OA\JsonContent(
     *         @OA\Property(property="success", type="boolean", example=false)
     *     )
     * )
     * @OA\Response(
     *     response=404,
     *     description="Car or credit program not found",
     *     @OA\JsonContent(
     *         @OA\Property(property="success", type="boolean", example=false),
     *         @OA\Property(property="error", type="string", example="Car not found")
     *     )
     * )
     */
    public function create(Request $request, CreditRequestService $creditRequestService): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $dto  = CreditRequestDto::createFromArray($data);
            $creditRequestService->validate($dto);
            $creditRequestService->createRequest($dto);

            return new JsonResponse(['success' => true], Response::HTTP_CREATED);

        } catch (Exception $e) {
            return new JsonResponse(['success' => false], Response::HTTP_BAD_REQUEST);
        }
    }

}
