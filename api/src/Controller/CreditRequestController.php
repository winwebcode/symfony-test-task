<?php

namespace App\Controller;

use App\DTO\CreditRequestDto;
use App\Services\CreditRequestService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreditRequestController extends AbstractController
{

    /**
     * @Route("/api/v1/credit/request", name="api_credit_request", methods={"POST"})
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
