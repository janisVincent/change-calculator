<?php

declare(strict_types=1);

namespace AppBundle\Registry;

use AppBundle\Calculator\AbstractCalculator;
use AppBundle\Calculator\CalculatorInterface;
use AppBundle\Calculator\Mk1Calculator;
use AppBundle\Calculator\Mk2Calculator;

final class CalculatorRegistry implements CalculatorRegistryInterface
{
    /**
     * @param string $model Indicates the model of automaton
     *
     * @return CalculatorInterface|null The calculator, or null if no CalculatorInterface supports that model
     */
    public function getCalculatorFor(string $model): ?CalculatorInterface
    {
        switch ($model) {
            case AbstractCalculator::MODEL_MK1:
                $calculator = new Mk1Calculator();
                break;
            case AbstractCalculator::MODEL_MK2:
                $calculator = new Mk2Calculator();
                break;
            default:
                $calculator = null;
                break;
        }

        return $calculator;
    }
}
