# Yalesov\Yaml

[![Build Status](https://travis-ci.org/yalesov/php-yaml.svg)](https://travis-ci.org/yalesov/php-yaml)

Wrapper around Symfony's Yaml parser - added `__DIR__` support.

# Installation

[Composer](http://getcomposer.org/):

```json
{
  "require": {
    "yalesov/yaml": "2.*"
  }
}
```

# Usage

Two constants added:
- `__DIR__`: behave as expected
- `___DIR___` (an extra underscore around): literal `__DIR__`

Parse a Yaml file `foo/bar.yml`:

```php
use Yalesov\Yaml\Yaml;
$parsedArray = Yaml::parse('foo/bar.yml');
```

Parse a Yaml string `foo: bar` (of course, neither `__DIR__` nor `___DIR___` would be available)

```php
use Yalesov\Yaml\Yaml;
$parsedArray = Yaml::parse('foo: bar');
```
