# axy/pkg-unit

Base classes for axy packages unit testing.

[![Latest Stable Version](https://img.shields.io/packagist/v/axy/pkg-unit.svg?style=flat-square)](https://packagist.org/packages/axy/pkg-unit)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.1-8892BF.svg?style=flat-square)](https://php.net/)
[![Tests](https://github.com/axypro/pkg-unit/actions/workflows/test.yml/badge.svg)](https://github.com/axypro/pkg-unit/actions/workflows/test.yml)
[![Coverage Status](https://coveralls.io/repos/github/axypro/pkg-unit/badge.svg?branch=master)](https://coveralls.io/github/axypro/pkg-unit?branch=master)
[![License](https://poser.pugx.org/axy/pkg-unit/license)](LICENSE)

This library is used in axy-packages for unit testing at the development stage.
Uses PHPUnit 10.

* [BaseAxyTestCase](doc/BaseAxyTestCase.md)
    * [assertPartiallySame()](doc/assertPartiallySame.md)
    * [assertItemsPartiallySame()](doc/assertItemsPartiallySame.md)
* [TestBootstrap](doc/TestBootstrap.md)
* [$this->tmpDir()](doc/TestTmpDir.md)
