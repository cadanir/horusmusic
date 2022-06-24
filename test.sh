#!/bin/bash

# check that Symfony server is running:
#   symfony check:requirements
#   symfony check:security
#   php bin/console about
#   symfony server:start

echo
echo "Running: php bin/console debug:router"
php bin/console debug:router

echo
echo "Running: curl --silent -c cookies.txt http://127.0.0.1:8000/circle/2 | jq ."
curl --silent -c cookies.txt http://127.0.0.1:8000/circle/2 | jq .

echo
echo "Running: curl --silent -b cookies.txt http://127.0.0.1:8000/triangle/3/4/5 | jq ."
curl --silent -b cookies.txt http://127.0.0.1:8000/triangle/3/4/5 | jq .

echo
echo "Running: curl --silent -b cookies.txt http://127.0.0.1:8000/geometry_calculator | jq ."
curl --silent -b cookies.txt http://127.0.0.1:8000/geometry_calculator | jq .
