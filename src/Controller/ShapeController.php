<?php
// src/Controller/ShapeController.php
namespace App\Controller;

use App\Service\Circle;
use App\Service\Triangle;
use App\Service\GeometryCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\RequestStack;

class ShapeController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/triangle/{a}/{b}/{c}", methods={"GET","HEAD"})
     */
    public function triangle(Triangle $triangle, string $a, string $b, string $c): Response
    {
        // $encoders = [new JsonEncoder()];  
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $session = $this->requestStack->getSession(); 

        $triangle->setA($a);
        $triangle->setB($b);
        $triangle->setC($c);

        $area = $triangle->getArea();
        $perimeter = $triangle->getPerimeter();

        // return number_format(round($this->a + $this->b + $this->c, 2, PHP_ROUND_HALF_DOWN), 2);
        $shape = [
            'type' => 'triangle',
            'a' => $a == intval($a) ? sprintf("%.1f", $a) : sprintf("%.2f", $a),
            'b' => $b == intval($b) ? sprintf("%.1f", $b) : sprintf("%.2f", $b),
            'c' => $c == intval($c) ? sprintf("%.1f", $c) : sprintf("%.2f", $c),
            'surface' => $area == intval($area) ? sprintf("%.1f", $area) : sprintf("%.2f", $area),
            'circumference' => $perimeter == intval($perimeter) ? sprintf("%.1f", $perimeter) : sprintf("%.2f", $perimeter),
        ];

        $json = $serializer->serialize($shape, 'json');

        $session->set('triangle', $json);

        return new Response($json);
    }

    // attribute instead of annotation...
    #[Route('/circle/{radius}', name: 'radius', methods: ['GET', 'HEAD'])]
    public function circle(Circle $circle, string $radius): Response
    {
        // $encoders = [new JsonEncoder()];  
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $session = $this->requestStack->getSession(); 

        $circle->setR($radius);

        $r = $circle->getR();
        $s = $circle->getArea();
        $c = $circle->getPerimeter();

        $shape = [
            'type' => 'circle',
            'radius' => $r == intval($r) ? sprintf("%.1f", $r) : sprintf("%.2f", $r),
            'surface' => $s == intval($s) ? sprintf("%.1f", $s) : sprintf("%.2f", $s),
            'circumference' => $c == intval($c) ? sprintf("%.1f", $c) : sprintf("%.2f", $c),
        ];

        // $this->addFlash('success', $shape);
        $json = $serializer->serialize($shape, 'json');

        $session->set('circle', $json);

        return new Response($json);
    }

    #[Route('/geometry_calculator', methods: ['GET', 'HEAD'])]
    public function geometry_calculator(): Response
    {
        // $encoders = [new JsonEncoder()];  
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $session = $this->requestStack->getSession(); 

        $Circle = new Circle();
        $Triangle = new Triangle();
        $GeoCalc = new GeometryCalculator();

        $circle = $session->get('circle');
        $triangle = $session->get('triangle');

        $serializer->deserialize($circle, Circle::class, 'json', [ObjectNormalizer::OBJECT_TO_POPULATE => $Circle]);
        $serializer->deserialize($triangle, Triangle::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $Triangle]);
        $circle = json_decode($circle);
        $GeoCalc->setCircle($Circle);
        $Circle->setR($circle->radius);
        $GeoCalc->setTriangle($Triangle);

        $a = $GeoCalc->getSumOfAreas();
        $p = $GeoCalc->getSumOfPerimeters();
        $shape = [
            /*
            'AreaCircle' => $Circle->getArea(),
            'AreaTriangle' => $Triangle->getArea(),
            'PeriCircle' => $Circle->getPerimeter(),
            'PeriTriangle' => $Triangle->getPerimeter(),
            */
            'sumOfAreas' => $a == intval($a) ? sprintf("%.1f", $a) : sprintf("%.2f", $a),
            'sumOfPerimeters' => $p == intval($p) ? sprintf("%.1f", $p) : sprintf("%.2f", $p),
        ];
        $json = $serializer->serialize($shape, 'json');
        return new Response($json);
    }
}
