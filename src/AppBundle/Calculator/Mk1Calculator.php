<?php

declare(strict_types=1);

namespace AppBundle\Calculator;

final class Mk1Calculator extends AbstractCalculator
{
    public function __construct()
    {
        $this->model = self::MODEL_MK1;
        $this->changeTypes = [self::CHANGE_COIN1];
    }
}
