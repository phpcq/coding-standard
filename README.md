[![Build Status](https://travis-ci.org/contao-community-alliance/coding-standard.svg?style=flat-square&label=stable build)](https://travis-ci.org/contao-community-alliance/coding-standard)
[![Latest Version tagged](http://img.shields.io/github/tag/contao-community-alliance/coding-standard.svg?style=flat-square)](https://github.com/contao-community-alliance/coding-standard/tags)
[![Latest Version on Packagist](http://img.shields.io/packagist/v/contao-community-alliance/coding-standard.svg?style=flat-square)](https://packagist.org/packages/contao-community-alliance/coding-standard)
[![Installations via composer per month](http://img.shields.io/packagist/dm/contao-community-alliance/coding-standard.svg?style=flat-square)](https://packagist.org/packages/contao-community-alliance/coding-standard)

Coding Standards
================

This repository contains the Contao Community Alliance coding standard definitions and style checker rules.

The rules are for [phpcs](https://github.com/squizlabs/PHP_CodeSniffer) and [phpmd](https://github.com/phpmd/phpmd).

Usage
-----

The most convenient usage is to use via [CCABS](https://github.com/contao-community-alliance/build-system).
Simply put the following into your projects `build.default.properties` file:

```
phpcs.standard=${basedir}/vendor/contao-community-alliance/coding-standard/phpcs/ContaoCommunityAlliance/ruleset.xml
phpmd.ruleset=${basedir}/vendor/contao-community-alliance/coding-standard/phpmd/ruleset.xml
```
