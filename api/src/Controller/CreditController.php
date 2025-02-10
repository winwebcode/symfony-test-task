<?php

namespace App\Controller;

use App\DTO\CreditCalculateDto;
use App\Services\CreditService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreditController extends AbstractController
{

    /**
     * @Route("/api/v1/credit/calculate", name="api_credit_calculate", methods={"GET"})
     */
    public function calculate(
        Request       $request,
        CreditService $creditService
    ): JsonResponse {
        $dto = CreditCalculateDto::createFromRequest($request);
        $creditService->validate($dto);

        $result = $creditService->calculate($dto);

        return new JsonResponse($result);

    }
}
