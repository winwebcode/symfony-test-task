<?php

namespace App\Controller;


use App\Services\CreditService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreditController extends AbstractController
{
    private $creditService;

    /**
     * @Route("/api/v1/credit/calculate", name="api_credit_calculate", methods={"GET"})
     */
    public function calculate(Request $request, CreditService $creditService): JsonResponse
    {
        $price = $request->query->getInt('price');
        $initialPayment = $request->query->get('initialPayment', 2, FILTER_VALIDATE_FLOAT);
        $loanTerm = $request->query->getInt('loanTerm');

        if (!$price || !$initialPayment || !$loanTerm) {
            return new JsonResponse(['error' => 'Missing required parameters'], 400);
        }

        $result = $this->creditService->calculateCredit($price, $initialPayment, $loanTerm);

        return new JsonResponse($result);

    }
}
