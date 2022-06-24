# horusmusic
Little Symfony project for testing purpose.

**Message from Punam Patel:**

```
Horus Music Application

Punam Patel <punam.patel@horusmusic.global>
	
Hi Cengiz, 
 
Welcome to the job application process for work at Horus Music on open position for Senior Backend PHP Developer!

We are offering a full-time remote job in an already formed web development department. We need to upgrade our web application into a web platform, and we are expanding our web development team. Primarily we use PHP and MySQL databases with the Symfony framework in Amazon environment.
 

We would like you to show us your best programming practices using all your skills and suitable techniques to solve ONE AND ONLY TASK. We want you to show off all your skills for this programmer's problem so that we can meet you better and understand your programming habits. Don't hesitate to write a little bit more code just to show us that you know even more. Let's get to the problem straight forward!

1.) ONE AND ONLY TASK

- you will use the MVC framework that we use: Symfony
- you will deliver solution in form of a Github repository.
- create 2 models/classes - Circle and Triangle
- implement 2 methods:

  I.) calculate surface: 
    circle surface: 3.14 * r * r
    triangle surface: Area = √[s(s-a)(s-b)(s-c)] with s = (a + b + c)/2.
       Example:
       triangle as: a=3 b=6 c=7
         semi-perimeter: s = (a + b + c)/2 = (3 + 6 + 7)/2 = 8. 
         area of the triangle using the Heron's formula
         A = √[s(s-a)(s-b)(s-c)]
         = √[8(8-3)(8-6)(8-7)]
         = √[8 × 5 × 2 × 1]
         = √(80)
         ≈ 8.94

  II.) calculate diameter: 
    circle diameter: r * 2
    circle perimeter: 3.14 * r * 2
    triangle perimeter: a + b + c 

- create routes:
  [GET] /triangle/{a}/{b}/{c}
  [GET] /circle/{radius}
- routes must return JSON with serialized objects and calculated surfaces and diameters. For example:
{
 "type": "circle",
 "radius": 2.0,
 "surface": 12.56,
 "circumference": 12.56,
}

or

{
 "type": "triangle",
 "a": 3.0,
 "b": 4.0,
 "c": 5.0,
 "surface": 6.0,
 "circumference": 12.0,
}

- create service/or similar structure for the given framework (for example app.geometry_calculator)
```
   **Sorry I have not understood this point, so instead I will add another route:** 
   *[GET] /geometry_calculator*
     
```  
- implement method for sum of areas for two given objects
- implement method for sum of diameters for two given objects
```
   **Those 2 methods will be returned by the route** *[GET] /geometry_calculator*
```
- please return us your solution at least in a period of 24 hours.

2.) Also, we would like to know more about how much monthly salary will suit your needs?

Kind regards, 

Punam Patel
Phone: +44 (0) 116 253 0203
Email: punam.patel@horusmusic.global
Head Office:  The Old School, 346 Loughborough Road, Leicester, LE4 5PJ, United Kingdom 	 
www.horusmusic.global 
```

### Answer

- project repository:
  -  https://github.com/cadanir/horusmus
- Monthly salary or the equivalent as freelance/contractor:
  -  I will let this to your discretion *or ~3500-4000 GBP/month.*


### Tasks to fulfill this request

We suppose:
  - PHP already installed 
  - and we work with Debian based Linux OS
  - also the *jq* JSON formater tool must be already installed
  - we use Symfony session to store data, no database

```bash
php -v
jq --version
```

The previous command should output the equivalent of:
```
PHP 8.1.2 (cli) (built: Apr 24 2022 08:36:32) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.1.2, Copyright (c) Zend Technologies
    with Zend OPcache v8.1.2, Copyright (c), by Zend Technologies
    
jq-1.6
```

### Start the project

Create a folder for the project and install *symfony-cli*.
```bash

projectName=horusmusic
projectDir=~/wrk/php/symfony/$projectName
mkdir $projectDir
cd $projectDir
```

#### Install *symfony-cli*

```bash
wget https://github.com/symfony-cli/symfony-cli/releases/download/v5.4.11/symfony-cli_5.4.11_amd64.deb
sudo dpkg -i symfony-cli_5.4.11_amd64.deb

# or:
#   curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash
#   sudo apt install symfony-cli
```

#### Create the project

```bash
projectName=horusmusic
projectDir=~/wrk/php/symfony/$projectName

symfony new $projectName
cd $projectDir/$projectName
```

#### Add required Symfony component(s) and start the Symfony internal Web server
```bash
projectName=horusmusic
projectDir=~/wrk/php/symfony/$projectName
cd $projectDir/$projectName

composer require symfony/serializer
composer require symfony/serializer-pack
composer require symfony/profiler-pack
symfony server:start  # alternatively, you can run:  ./start.sh
```

Also we configure Symfony session like the following:
```bash
cat config/packages/framework.yaml
```
```
...
session:
        # handler_id: null
        handler_id: 'session.handler.native_file'
...
```
#### Create classes as Symfony services

```bash
mkdir src/Service
cat > src/Service/Circle.php <<-EOD
// src/Service/Circle.php
namespace App\Service;

class Circle
{
//...
}
EOD

cat > src/Service/Triangle.php <<-EOD
<?php
// src/Service/Triangle.php
namespace App\Service;

class Triangle
{
//...
EOD

cat > src/Service/Triangle.php <<-EOD
<?php
// src/Service/GeometryCalculator.php
namespace App\Service;

use App\Service\Circle;
use App\Service\Triangle;

class GeometryCalculator

//...
EOD
```
#### Create a controller
```bash
head src/Controller/ShapeController.php 
<?php
// src/Controller/ShapeController.php
namespace App\Controller;

use App\Service\Circle;
use App\Service\Triangle;
use App\Service\GeometryCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//...
```

### Tests with *curl*

Ensure that the Symfony server is already running in another terminal:
```bash
projectName=horusmusic
projectDir=~/wrk/php/symfony/$projectName
cd $projectDir/$projectName

symfony server:start
```

```bash
curl -c cookies.txt http://127.0.0.1:8000/circle/2 | jq .
curl -b cookies.txt http://127.0.0.1:8000/triangle/3/4/5 | jq .
curl -b cookies.txt http://127.0.0.1:8000/geometry_calculator
```

You can also run instead the above, the following *test.sh* script:
```bash
./test.sh  
```
You will see an output like this:
```
Running: php bin/console debug:router
 ------------------------------- ---------- -------- ------ -------------------------- 
  Name                            Method     Scheme   Host   Path                      
 ------------------------------- ---------- -------- ------ -------------------------- 
  _preview_error                  ANY        ANY      ANY    /_error/{code}.{_format}  
  app_shape_triangle              GET|HEAD   ANY      ANY    /triangle/{a}/{b}/{c}     
  radius                          GET|HEAD   ANY      ANY    /circle/{radius}          
  app_shape_geometry_calculator   GET|HEAD   ANY      ANY    /geometry_calculator      
 ------------------------------- ---------- -------- ------ -------------------------- 


Running: curl --silent -c cookies.txt http://127.0.0.1:8000/circle/2 | jq .
{
  "type": "circle",
  "radius": "2.0",
  "surface": "12.57",
  "circumference": "12.57"
}

Running: curl --silent -b cookies.txt http://127.0.0.1:8000/triangle/3/4/5 | jq .
{
  "type": "triangle",
  "a": "3.0",
  "b": "4.0",
  "c": "5.0",
  "surface": "6.0",
  "circumference": "12.0"
}

Running: curl --silent -b cookies.txt http://127.0.0.1:8000/geometry_calculator | jq .
{
  "sumOfAreas": "18.57",
  "sumOfPerimeters": "24.57"
}
```
#### Support
For any questions or support write to cadanir[at]gmail.com.

*Have a nice day.*

Cengiz ADANIR
