<?php

declare(strict_types=1);

namespace AppBundle\Calculator;

use AppBundle\Registry\CalculatorRegistry;

final class Mk1Calculator extends AbstractCalculator
{
    /** {@inheritdoc} */
    protected $model = CalculatorRegistry::MODEL_MK1;

    /** {@inheritdoc} */
    protected $changeTypes = [self::COIN1];
}
