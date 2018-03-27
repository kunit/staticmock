#!/bin/bash -xeu
# This script
PHP_MAJOR_VERSION=$(php -r "echo PHP_MAJOR_VERSION;");

if expr "$PHP_MAJOR_VERSION" ">=" "7" ; then
	pecl install uopz
else
	pecl install runkit
fi
