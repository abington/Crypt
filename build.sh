#!/bin/bash
cd ~/Projects/chippyash/source/Crypt
vendor/phpunit/phpunit/phpunit -c test/phpunit.xml --testdox-html contract.html test/
tdconv -t "Chippyash Crypt" contract.html docs/Test-Contract.md
rm contract.html

