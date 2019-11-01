<?php

declare(strict_types=1);

namespace AppBundle\Calculator;

use AppBundle\Registry\CalculatorRegistry;

final class Mk2Calculator extends AbstractCalculator
{
    /** {@inheritdoc} */
    protected $model = CalculatorRegistry::MODEL_MK2;

    /** {@inheritdoc} */
    protected $changeTypes = [self::BILL10, self::BILL5, self::COIN2];
}
