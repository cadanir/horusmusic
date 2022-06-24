<?php
// src/Service/Triangle.php
namespace App\Service;

class Triangle
{
    private $a;
    private $b;
    private $c;

    function __construct($a=1, $b=1, $c=1)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }

    public function setA($newA)
    {
        $this->a = $newA;
    }

    public function setB($newB)
    {
        $this->b = $newB;
    }

    public function setC($newC)
    {
        $this->c = $newC;
    }

    public function getA()
    {
          return $this->a;
    }

    public function getB()
    {
          return $this->b;
    }

    public function getC()
    {
          return $this->c;
    }

    public function getPerimeter(): float
    {
        return $this->a + $this->b + $this->c;
    }

    public function getArea(): float
    {
        // area = √[s(s-a)(s-b)(s-c)]
        $area = 0;
        $semiPerimeter = $this->getPerimeter() / 2;

        $area = $semiPerimeter *($semiPerimeter - $this->a)*($semiPerimeter - $this->b)*($semiPerimeter - $this->c);
        $area = sqrt($area);
        return $area;
    }
}
