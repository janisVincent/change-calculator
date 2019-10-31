<?php

declare(strict_types=1);

namespace AppBundle\Calculator;

use AppBundle\Model\Change;

abstract class AbstractCalculator implements CalculatorInterface
{
    const MODEL_MK1 = 'mk1';
    const MODEL_MK2 = 'mk2';

    protected const CHANGE_BILL10 = 'bill10';
    protected const CHANGE_BILL5 = 'bill5';
    protected const CHANGE_COIN2 = 'coin2';
    protected const CHANGE_COIN1 = 'coin1';

    /** @var string */
    protected $model;

    /**
     * Authorized change types, sorted by descending value
     *
     * @var array
     */
    protected $changeTypes = [];

    /**
     * @return string Indicates the model of automaton
     */
    public function getSupportedModel(): string
    {
        return $this->model;
    }

    /**
     * @param int $amount The amount of money to turn into change
     *
     * @return Change The change, or null if the operation is impossible
     */
    public function getChange(int $amount): ?Change
    {
        $change = new Change();
        foreach ($this->changeTypes as $changeType) {
            if (property_exists(Change::class, $changeType)) {
                $ceilValue = $this->getChangeTypeValue($changeType);
                while ($amount >= $ceilValue) {
                    $change->{$changeType}++;
                    $amount -= $ceilValue;
                }
            }
        }
        if ($amount > 0) {
            return null;
        }

        return $change;
    }

    /**
     * Get integer value for a given change type
     *
     * @param string $changeType
     *
     * @return int
     */
    private function getChangeTypeValue(string $changeType)
    {
        switch ($changeType) {
            case self::CHANGE_BILL10:
                $value = 10;
                break;
            case self::CHANGE_BILL5:
                $value = 5;
                break;
            case self::CHANGE_COIN2:
                $value = 2;
                break;
            case self::CHANGE_COIN1:
            default:
                $value = 1;
                break;
        }

        return $value;
    }
}
