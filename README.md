Devtools
========

[![Build Status](https://img.shields.io/travis/sinergi/devtools/master.svg?style=flat)](https://travis-ci.org/sinergi/devtools)
[![Latest Stable Version](http://img.shields.io/packagist/v/sinergi/devtools.svg?style=flat)](https://packagist.org/packages/sinergi/devtools)
[![Total Downloads](https://img.shields.io/packagist/dm/sinergi/devtools.svg?style=flat)](https://packagist.org/packages/sinergi/devtools)
[![License](https://img.shields.io/packagist/l/sinergi/devtools.svg?style=flat)](https://packagist.org/packages/sinergi/devtools)

Set of PHP development tools to allow working on multiple projects. Allows to work on dependencies of a project 
without compromises

## Requirements

This library uses PHP 5.4+.

## Installation

It is recommended that you install the Devtools library [through composer](http://getcomposer.org/). To do so, 
add the following lines to your ``composer.json`` file.

```json
{
    "require": {
       "sinergi/devtools": "dev-master"
    }
}
```

## Examples

No real doc yet, sorry. But this is basically what needs to be added to composer.json:

```json
{
    "scripts": {
        "post-autoload-dump": [
            "Sinergi\\Devtools\\Setup::setupAutoloader",
            "Sinergi\\Devtools\\Setup::setupPhpStorm"
        ]
    }
}
```

And this is an example of the project.xml file:

```xml
<project>
    <sources>
        <directory>../dependency/</directory>
    </sources>
</project>
```
