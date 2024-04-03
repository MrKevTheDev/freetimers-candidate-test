<?php

namespace Kev\FreetimersCandidateTest;

use InvalidArgumentException;

class TopsoilCalculator
{

    const SOIL_DENSITY_ADJUSTMENT = 0.025;
    const BAG_VOLUME = 1.4;  // Assuming that we are adjusting for a bag volume of 1.4
    protected string $lengthUnit;
    protected string $widthUnit;
    protected string $depthUnit;
    protected $length;
    protected $width;
    protected $depth;
    protected array $validUnits = [
        'm',
        'ft',
        'yd',
        'cm',
        'in',
    ];

    protected array $conversionRates = [
        'ft' => 0.3048,
        'yd' => 0.9144,
        'in' => 0.0254,
        'cm' => 0.01,
    ];

    public function setUnits($depthUnit, $lengthUnit, $widthUnit): self
    {
        $this->setDepthUnit($depthUnit);
        $this->setLengthUnit($lengthUnit);
        $this->setWidthUnit($widthUnit);
        return $this;
    }

    public function setDepthUnit($unit)
    {
        if (!in_array($unit, $this->validUnits)) {
            throw new InvalidArgumentException("Invalid unit: $unit. Valid units are 'm', 'ft', 'yd', 'cm', or 'in'");
        }
        $this->depthUnit = $unit;
    }

    /**
     * Sets the dimensions of the TopsoilCalculator object.
     *
     * @param int|float $length The length of the topsoil in feet.
     * @param int|float $width The width of the topsoil in feet.
     * @param int|float $depth The depth of the topsoil in inches.
     * @return TopsoilCalculator Returns the modified TopsoilCalculator object.
     */
    public function setDimensions($length, $width, $depth): self
    {
        $this->setDimension('length', $length);
        $this->setDimension('width', $width);
        $this->setDimension('depth', $depth);
        return $this;
    }

    protected function setDimension(string $dimension, $value): void
    {
        $this->validateDimensions($value , $dimension);
        $this->$dimension = $value;
    }

    protected function validateDimensions($value, $dimension): bool
    {
        if (!is_numeric($value) || $value <= 0){
            throw new InvalidArgumentException("{$dimension} {$value} must be a positive number");
        }
        return true;
    }

    public function saveToDatabase(TopsoilCalculatorService $dbService): bool
    {
        $bags = $this->calculateBags();
        if (!$dbService->insertCalculatedBags($bags)) {
            throw new InvalidArgumentException("Failed to save the result to the database");
        }
        return true;
    }

    /**
     * Calculates the quantity of bags needed for a given area.
     *
     * @return float The quantity of bags needed.
     */
    public function calculateBags(): float
    {
        $this->convertToMeters();
        $area = $this->length * $this->width;
        $adjustedArea = $area * self::SOIL_DENSITY_ADJUSTMENT;
        $bagQuantity = $adjustedArea * self::BAG_VOLUME;
        return ceil($bagQuantity);
    }

    protected function convertToMeters()
    {
        $this->length = $this->convertDimensionToMeters($this->length, $this->lengthUnit);
        $this->width = $this->convertDimensionToMeters($this->width, $this->widthUnit);
        $this->depth = $this->convertDimensionToMeters($this->depth, $this->depthUnit);
    }

    private function convertDimensionToMeters($dimension, $unit)
    {
        if ($unit !== 'm') {
            $dimension *= $this->conversionRates[$unit];
        }
        return $dimension;
    }

    public function getWidthUnit(): string
    {
        return $this->widthUnit;
    }

    public function setWidthUnit($unit): self
    {

        if (!in_array($unit, $this->validUnits)) {
            throw new InvalidArgumentException("Invalid unit: $unit. Valid units are 'm', 'ft', 'cm', or 'yd'");
        }
        $this->widthUnit = $unit;
        return $this;
    }

    public function getLengthUnit(): string
    {
        return $this->lengthUnit;
    }

    public function setLengthUnit($unit): self
    {

        if (!in_array($unit, $this->validUnits)) {
            throw new InvalidArgumentException("Invalid unit: $unit Valid units are 'm', 'ft', 'cm', or 'yd'");
        }
        $this->lengthUnit = $unit;
        return $this;
    }

    public function getDepth()
    {
        return $this->depth;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getLength()
    {
        return $this->length;
    }

}
