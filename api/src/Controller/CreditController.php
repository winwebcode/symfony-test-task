<?php

namespace App\Controller;

use App\DTO\CreditCalculateDto;
use App\Services\CreditService;
use Exception;
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
     * @Route("/api/v1/credit/calculate", name="api_credit_calculate", methods={"GET"})
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
