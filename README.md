Project
=======

[![Build Status](https://img.shields.io/travis/sinergi/project/master.svg?style=flat)](https://travis-ci.org/sinergi/project)
[![Latest Stable Version](http://img.shields.io/packagist/v/sinergi/project.svg?style=flat)](https://packagist.org/packages/sinergi/project)
[![Total Downloads](https://img.shields.io/packagist/dm/sinergi/project.svg?style=flat)](https://packagist.org/packages/sinergi/project)
[![License](https://img.shields.io/packagist/l/sinergi/project.svg?style=flat)](https://packagist.org/packages/sinergi/project)

Project Dependency Workflow. Allows to work on dependencies of a project without compromises.

## Requirements

This library uses PHP 5.4+.

## Installation

It is recommended that you install the Project library [through composer](http://getcomposer.org/). To do so, add the following lines to your ``composer.json`` file.

```json
{
    "require": {
       "sinergi/project": "dev-master"
    }
}
```

## Examples

No reat doc yet, sorry. But this is basically what needs to be added to composer.json:

```json
    "scripts": {
        "post-autoload-dump": [
            "Sinergi\\Project\\Setup::setupAutoloader",
            "Sinergi\\Project\\Setup::setupPhpStorm"
        ]
    }
```

And this is an example of the project.xml file:

```json
<project>
    <sources>
        <directory>../dependency/</directory>
    </sources>
</project>
```
