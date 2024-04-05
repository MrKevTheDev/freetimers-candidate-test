<?php

namespace Tests;

use Kev\FreetimersCandidateTest\TopsoilCalculator;
use Kev\FreetimersCandidateTest\TopsoilCalculatorService;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

/**
 * Class TopsoilCalculatorDatabaseTest
 *
 * Tests for the saveToDatabase method of the TopsoilCalculator class.
 * This test assumes that a fully functional PDO database connection
 * and applicable database exist.
 *
 * @package Tests
 */
class TopsoilCalculatorDatabaseTest extends TestCase
{
    /**
     * @var TopsoilCalculator
     */
    private $topsoilCalculator;

    /**
     * @var TopsoilCalculatorService
     */
    private $databaseService;

    protected function setUp() : void
    {
        // Please replace the variables in the constructor accordingly
        $this->databaseService = new TopsoilCalculatorService();
        $this->topsoilCalculator = new TopsoilCalculator();
    }

    /**
     * Test whether save_to_database works with valid inputs.
     *
     * @return void
     */
    public function test_save_to_database_with_valid_inputs(): void
    {
        $this->topsoilCalculator->setUnits('m','m','m')
            ->setDimensions(2.5, 2.5, 2.5);
        $this->expectNotToPerformAssertions();
   ;
        $this->assertTrue( $this->topsoilCalculator->saveToDatabase($this->databaseService));
    }


}