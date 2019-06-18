[![Build Status](https://travis-ci.org/phpcq/coding-standard.svg?style=flat-square&label=stable build)](https://travis-ci.org/phpcq/coding-standard)
[![Latest Version tagged](http://img.shields.io/github/tag/phpcq/coding-standard.svg?style=flat-square)](https://github.com/phpcq/coding-standard/tags)
[![Latest Version on Packagist](http://img.shields.io/packagist/v/phpcq/coding-standard.svg?style=flat-square)](https://packagist.org/packages/phpcq/coding-standard)
[![Installations via composer per month](http://img.shields.io/packagist/dm/phpcq/coding-standard.svg?style=flat-square)](https://packagist.org/packages/phpcq/coding-standard)

Coding Standards
================

This repository contains the PHPCQ coding standard definitions and style checker rules.

The rules are for [phpcs](https://github.com/squizlabs/PHP_CodeSniffer) and [phpmd](https://github.com/phpmd/phpmd).

Usage
-----

The most convenient usage is to use via [phpcq/phpcq](https://github.com/phpcq/phpcq).
Simply put the following into your projects `build.default.properties` file:

```
phpcs.standard=${basedir}/vendor/phpcq/coding-standard/phpcs/PhpCodeQuality/ruleset.xml
phpmd.ruleset=${basedir}/vendor/phpcq/coding-standard/phpmd/ruleset.xml
```
