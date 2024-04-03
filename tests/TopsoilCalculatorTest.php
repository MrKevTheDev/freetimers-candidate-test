<?php
namespace Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Kev\FreetimersCandidateTest\TopsoilCalculator;

class TopsoilCalculatorTest extends TestCase
{
    private TopsoilCalculator $calculator;

    public function setUp(): void
    {
        $this->calculator = new TopsoilCalculator();
    }

    public function it_is_true()
    {
        $this->assertSame(true, true);
    }

    /**
     * @test
     */
    public function it_allows_setting_valid_length_unit()
    {
        $validUnits = [
            'm',
            'ft',
            'yd',
            'cm',
            'in',
        ];

        foreach ($validUnits as $unit) {
            $this->calculator->setLengthUnit($unit);
            $this->assertSame($unit, $this->calculator->getLengthUnit());
        }
    }

    /**
     * @test
     */
    public function it_throws_exception_for_invalid_length_unit()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches("/Invalid unit/i");

        $this->calculator->setLengthUnit('invalid_unit');
    }

    public function it_calculates_bags()
    {
        $topsoilCalculator = $this->calculator;
        // Set valid measurements as parameters
        $topsoilCalculator->setDimensions(10, 10, 10);
        $topsoilCalculator->setUnits('m', 'm', 'm');

        // Test baseline with 10m cubed, expect 35 bags
        $this->assertEquals(35, $topsoilCalculator->calculateBags());

        // Test different measurements as parameters, expect different number of bags
        $topsoilCalculator->setDimensions(5, 5, 5);
        $this->assertEquals(9, $topsoilCalculator->calculateBags());

    }

    public function it_sets_values_when_passed()
    {
        $this->calculator->setDimensions(1, 2, 3);

        $this->assertSame(1, $this->calculator->getLength());
        $this->assertSame(2, $this->calculator->getWidth());
        $this->assertSame(3, $this->calculator->getDepth());
    }

    public function it_exceptions_when_passed_a_negative_value()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculator->setDimensions(-1, 2, 3);
    }

    public function it_exceptions_when_passed_a_sting_value()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculator->setDimensions("a", 2, 3);
    }

    public function it_exceptions_when_passed_a_null_value()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculator->setDimensions(null, 2, 3);
    }
    public function it_exceptions_when_passed_a_number_string_value()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculator->setDimensions("1", 2, 3);
    }


}