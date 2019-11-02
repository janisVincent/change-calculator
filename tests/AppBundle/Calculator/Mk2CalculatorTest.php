<?php

namespace Tests\AppBundle\Calculator;

use AppBundle\Calculator\CalculatorInterface;
use AppBundle\Model\Change;
use AppBundle\Calculator\Mk2Calculator;
use PHPUnit\Framework\TestCase;

class Mk2CalculatorTest extends TestCase
{
    /**
     * @var CalculatorInterface
     */
    private $calculator;

    protected function setUp()
    {
        $this->calculator = new Mk2Calculator();
    }

    public function testGetSupportedModel()
    {
        $this->assertEquals('mk2', $this->calculator->getSupportedModel());
    }

    public function testGetChangeEasy()
    {
        $change = $this->calculator->getChange(2);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(1, $change->coin2);

        $change = $this->calculator->getChange(4);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(2, $change->coin2);

        $change = $this->calculator->getChange(5);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(1, $change->bill5);

        $change = $this->calculator->getChange(6);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(3, $change->coin2);

        $change = $this->calculator->getChange(7);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(0, $change->bill10);
        $this->assertEquals(1, $change->bill5);
        $this->assertEquals(1, $change->coin2);

        $change = $this->calculator->getChange(8);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(0, $change->bill10);
        $this->assertEquals(0, $change->bill5);
        $this->assertEquals(4, $change->coin2);

        $change = $this->calculator->getChange(9);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(0, $change->bill10);
        $this->assertEquals(1, $change->bill5);
        $this->assertEquals(2, $change->coin2);

        $change = $this->calculator->getChange(10);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(1, $change->bill10);
        $this->assertEquals(0, $change->bill5);
        $this->assertEquals(0, $change->coin2);

        $change = $this->calculator->getChange(12);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(1, $change->bill10);
        $this->assertEquals(0, $change->bill5);
        $this->assertEquals(1, $change->coin2);

        $change = $this->calculator->getChange(15);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(1, $change->bill10);
        $this->assertEquals(1, $change->bill5);
        $this->assertEquals(0, $change->coin2);

        $change = $this->calculator->getChange(17);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(1, $change->bill10);
        $this->assertEquals(1, $change->bill5);
        $this->assertEquals(1, $change->coin2);
    }

    public function testGetChangeImpossible()
    {
        $change = $this->calculator->getChange(1);
        $this->assertNull($change);

        $change = $this->calculator->getChange(3);
        $this->assertNull($change);
    }

    public function testGetChangeHard()
    {
        $change = $this->calculator->getChange(6);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(0, $change->bill10);
        $this->assertEquals(0, $change->bill5);
        $this->assertEquals(3, $change->coin2);

        $change = $this->calculator->getChange(11);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(0, $change->bill10);
        $this->assertEquals(1, $change->bill5);
        $this->assertEquals(3, $change->coin2);

        $change = $this->calculator->getChange(14);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(1, $change->bill10);
        $this->assertEquals(0, $change->bill5);
        $this->assertEquals(2, $change->coin2);
    }
}