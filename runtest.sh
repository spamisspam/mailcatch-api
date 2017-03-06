#!/bin/bash
clear
rm -rf ./logs/*
rm -rf ./docs/*
composer -n -q update
./vendor/bin/phpunit --verbose --colors=never > ./logs/phpunit.log
./vendor/bin/phpcbf -n --tab-width=4 ./src/*.php >> ./logs/phpcs.log
./vendor/bin/phpcbf -n --tab-width=4 ./tests/*.php >> ./logs/phpcs.log
./vendor/bin/phpdoc -c ./phpdoc.tpl.xml > ./logs/phpdoc.log