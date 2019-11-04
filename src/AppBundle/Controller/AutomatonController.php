<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Registry\CalculatorRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/automaton")
 */
final class AutomatonController extends Controller
{
    /**
     * @Route("/{model}/change/{amount}", name="automaton_change",
     *     requirements={
     *         "amount": "\d+",
     *     }
     * )
     *
     * @param string             $model
     * @param int                $amount
     * @param CalculatorRegistry $calculatorRegistry
     *
     * @return JsonResponse
     */
    public function mk1Action(string $model, int $amount, CalculatorRegistry $calculatorRegistry)
    {
        $change = null;
        $calculator = $calculatorRegistry->getCalculatorFor($model);
        if (!is_null($calculator)) {
            $change = $calculator->getChange($amount);
            if (is_null($change)) {
                $httpResponseCode = 204;
            }
        } else {
            $httpResponseCode = 404;
        }

        return new JsonResponse($change, $httpResponseCode ?? 200);
    }
}
