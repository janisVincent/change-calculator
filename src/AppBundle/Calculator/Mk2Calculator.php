<?php

declare(strict_types=1);

namespace AppBundle\Calculator;

final class Mk2Calculator extends AbstractCalculator
{
    public function __construct()
    {
        $this->model = self::MODEL_MK2;
        $this->changeTypes = [self::CHANGE_BILL10, self::CHANGE_BILL5, self::CHANGE_COIN2];
    }
}
