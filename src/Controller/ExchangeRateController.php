<?php

namespace App\Controller;

use App\Repository\ExchangeRateRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ExchangeRateController extends AbstractController
{

    public function getExchangeRates(
        string $base,
        string $quote,
        Request $request,
        ExchangeRateRepository $exchangeRateRepository,
        SerializerInterface $normalizer
    ): JsonResponse
    {
        if(!($request->query->has("time_start") && $request->query->has("time_end"))){
            return new JsonResponse(["message" => "Missing required parameters time_start or time_end!"],
                JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $time_start = new DateTime($request->query->get("time_start"));
            $time_end = new DateTime($request->query->get("time_end"));
        } catch(\Exception $e){
            return new JsonResponse(["message" => "Wrong time format!"],
                JsonResponse::HTTP_BAD_REQUEST);
        }

        $exchangeRates = $exchangeRateRepository->findExchangeRates(
            $base,
            $quote,
            $time_start,
            $time_end
        );


        $normalizedExchangeRates = [];

        foreach($exchangeRates as $exchangeRate){
            $normalizedExchangeRate = $normalizer->normalize(
                $exchangeRate,
                "json",
                [AbstractNormalizer::IGNORED_ATTRIBUTES =>[
                    "id", "__initializer__",  "__cloner__", "__isInitialized__"
                ]]);
            $normalizedExchangeRates[] = $normalizedExchangeRate;
        }


        return new JsonResponse($normalizedExchangeRates);


    }
}
