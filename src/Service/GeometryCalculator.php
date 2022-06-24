<?php
// src/Service/GeometryCalculator.php
namespace App\Service;

use App\Service\Circle;
use App\Service\Triangle;

class GeometryCalculator
{
    private $Circle;
    private $Triangle;

    function __construct()
    {
        $this->Circle = new Circle();
        $this->Triangle = new Triangle(); 
    }

    public function setCircle($newC)
    {
        $this->Circle = $newC;
    }

    public function setTriangle($newT)
    {
        $this->Triangle = $newT;
    }

    public function getSumOfPerimeters(): float
    {
        return $this->Circle->getPerimeter() + $this->Triangle->getPerimeter();
    }

    public function getSumOfAreas(): float
    {
        return $this->Circle->getArea() + $this->Triangle->getArea();
    }
}
