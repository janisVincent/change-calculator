<?php

declare(strict_types=1);

namespace AppBundle\Calculator;

use AppBundle\Model\Change;
use AppBundle\Registry\CalculatorRegistry;

abstract class AbstractCalculator implements CalculatorInterface
{
    const BILL5 = 'bill5';
    const BILL10 = 'bill10';
    const COIN1 = 'coin1';
    const COIN2 = 'coin2';

    /**
     * Model name, as listed on registry
     *
     * @see CalculatorRegistry
     *
     * @var string
     */
    protected $model;

    /**
     * Authorized change item(s), sorted by descending value
     *
     * @see getChangeItemValue()
     *
     * @var array
     */
    protected $changeTypes = [self::BILL10, self::BILL5, self::COIN2, self::COIN1];

    /** {@inheritdoc} */
    public function getSupportedModel(): string
    {
        return $this->model;
    }

    /** {@inheritdoc} */
    public function getChange(int $amount): ?Change
    {
        $change = new Change();
        foreach ($this->changeTypes as $changeType) {
            $ceilValue = $this->getChangeItemValue($changeType);
            if (is_null($ceilValue)) {
                continue;
            }
            while ($amount >= $ceilValue) {
                $change->{$changeType}++;
                $amount -= $ceilValue;
            }
        }
        if ($amount > 0) {
            return null;
        }

        return $change;
    }

    /**
     * Get change item real value
     *
     * @param string $changeType
     *
     * @return int|null
     */
    private function getChangeItemValue(string $changeType): ?int
    {
        if (!property_exists(Change::class, $changeType)) {
            return null;
        }

        switch ($changeType) {
            case self::BILL10:
                $value = 10;
                break;
            case self::BILL5:
                $value = 5;
                break;
            case self::COIN2:
                $value = 2;
                break;
            case self::COIN1:
            default:
                $value = 1;
                break;
        }

        return $value;
    }
}
