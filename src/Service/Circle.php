<?php
// src/Service/Circle.php
namespace App\Service;

class Circle
{
    private $radius;

    function __construct($radius=1)
    {
        $this->radius = $radius;
    }

    public function setR($newR)
    {
        $this->radius = $newR;
    }

    public function getR()
    {
          return $this->radius;
    }

    public function getDiameter(): float
    {
        return $this->radius * 2;
    }

    public function getPerimeter(): float
    {
        // return M_PI * $this->getDiameter();
        return M_PI * $this->radius * 2;
    }

    public function getArea(): float
    {
        // area =  3.14 * r * r
        return M_PI * $this->radius ** 2;
    }
}
