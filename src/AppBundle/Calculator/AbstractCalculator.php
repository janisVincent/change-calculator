<?php

declare(strict_types=1);

namespace AppBundle\Calculator;

use AppBundle\Model\Change;
use AppBundle\Registry\CalculatorRegistry;

abstract class AbstractCalculator implements CalculatorInterface
{
    const COIN1 = 'coin1';
    const COIN2 = 'coin2';
    const BILL5 = 'bill5';
    const BILL10 = 'bill10';

    /**
     * Model name, as listed on registry
     *
     * @see CalculatorRegistry
     *
     * @var string
     */
    protected $model;

    /**
     * Authorized change "coin(s)"
     *
     * @see getChangeItemValue()
     *
     * @var array
     */
    protected $changeCoins = [self::COIN1, self::COIN2, self::BILL5, self::BILL10];

    /** {@inheritdoc} */
    public function getSupportedModel(): string
    {
        return $this->model;
    }

    /** {@inheritdoc} */
    public function getChange(int $amount): ?Change
    {
        $changeCoins = [];
        $changeCoinsByValue = [];
        foreach ($this->changeCoins as $changeCoin) {
            $coinValue = $this->getChangeItemValue($changeCoin);
            $changeCoins[] = $coinValue;
            $changeCoinsByValue[$coinValue] = $changeCoin;
        }
        // Ensure coins are listed by increasing value
        sort($changeCoins);
        array_unshift($changeCoins, 0);

        return $this->buildChange($changeCoins, $this->listCoinCombinations($changeCoins, $amount), $amount,
            $changeCoinsByValue);
    }

    /**
     * List existent coin combinations for each value <= $amount
     *
     * @param array $changeCoins
     * @param int   $amount
     *
     * @return array
     */
    public function listCoinCombinations(array $changeCoins, int $amount): array
    {
        $coins = [0];
        $minCoinsQuantity = [0];
        $changeCoinsLength = count($this->changeCoins);
        $coin = null;

        for ($inc = 1; $inc <= $amount; $inc++) {
            $minQuantity = PHP_INT_MAX;
            for ($i = 1; $i <= $changeCoinsLength; $i++) {
                $changeCoin = $changeCoins[$i];
                if ($changeCoin <= $inc) {
                    $quantity = $minCoinsQuantity[$inc - $changeCoin] + 1;
                    if ($quantity < $minQuantity) {
                        $minQuantity = $quantity;
                        $coin = $i;
                    }
                }
            }
            $minCoinsQuantity[$inc] = $minQuantity;
            $coins[$inc] = $coin;
        }

        return $coins;
    }

    /**
     * Build Change object, decrementing $amount by listed coin combinations
     *
     * @param array $changeCoins
     * @param array $coins
     * @param int   $amount
     * @param array $changeCoinsByValue
     *
     * @return Change|null
     */
    public function buildChange(array $changeCoins, array $coins, int $amount, array $changeCoinsByValue): ?Change
    {
        $change = new Change();
        while ($amount > 0) {
            $coinsAmount = $coins[$amount];
            if (!isset($changeCoins[$coinsAmount])) {
                return null;
            }
            $change->{$changeCoinsByValue[$changeCoins[$coinsAmount]]}++;
            $amount = $amount - $changeCoins[$coinsAmount];
        }

        return $change;
    }

    /**
     * Get change item real value
     *
     * @param string $changeItem
     *
     * @return int|null
     */
    private function getChangeItemValue(string $changeItem): ?int
    {
        if (!property_exists(Change::class, $changeItem)) {
            return null;
        }
        preg_match('/^[a-z]+([0-9]+)$/', $changeItem, $matches);
        if (!empty($matches)) {
            return (int) $matches[1];
        }

        return null;
    }
}
