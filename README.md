# HaikunatorPHP

[![Build Status](https://img.shields.io/endpoint.svg?url=https%3A%2F%2Factions-badge.atrox.dev%2Fatrox%2Fhaikunatorphp%2Fbadge&style=flat-square)](https://actions-badge.atrox.dev/atrox/haikunatorphp/goto)
[![Latest Version](https://img.shields.io/packagist/v/Atrox/haikunator.svg?style=flat-square)](https://packagist.org/packages/atrox/haikunator)
[![Coverage Status](https://img.shields.io/codecov/c/github/atrox/haikunatorphp.svg?style=flat-square)](https://codecov.io/gh/atrox/haikunatorphp)

Generate Heroku-like random names to use in your PHP applications.

## Installation

```
composer require atrox/haikunator
```

## Usage

Haikunator is pretty simple.

```php
use Atrox\Haikunator;

// default usage
Haikunator::haikunate() // => "wispy-dust-1337"

// custom length (default=4)
Haikunator::haikunate(["tokenLength" => 6]) // => "patient-king-887265"

// use hex instead of numbers
Haikunator::haikunate(["tokenHex" => true]) // => "purple-breeze-98e1"

// use custom chars instead of numbers/hex
Haikunator::haikunate(["tokenChars" => "HAIKUNATE"]) // => "summer-atom-IHEA"

// don't include a token
Haikunator::haikunate(["tokenLength" => 0]) // => "cold-wildflower"

// use a different delimiter
Haikunator::haikunate(["delimiter" => "."]) // => "restless.sea.7976"

// no token, space delimiter
Haikunator::haikunate(["tokenLength" => 0, "delimiter" => " "]) // => "delicate haze"

// no token, empty delimiter
Haikunator::haikunate(["tokenLength" => 0, "delimiter" => ""]) // => "billowingleaf"

// custom nouns and/or adjectives
Haikunator::$ADJECTIVES = ["red", "green", "blue"];
Haikunator::$NOUNS = ["reindeer"];
Haikunator::haikunate(); // => "blue-reindeer-4252"
```

## Options

The following options are available:

```php
Haikunator::haikunate([
  "delimiter" => "-",
  "tokenLength" => 4,
  "tokenHex" => false,
  "tokenChars" => "0123456789"
]);

// get/set nouns or adjectives
Haikunator::$ADJECTIVES
Haikunator::$NOUNS
```
*If ```tokenHex``` is true, it overrides any tokens specified in ```tokenChars```*

## Contributing

Everyone is encouraged to help improve this project. Here are a few ways you can help:

- [Report bugs](https://github.com/atrox/haikunatorphp/issues)
- Fix bugs and [submit pull requests](https://github.com/atrox/haikunatorphp/pulls)
- Write, clarify, or fix documentation
- Suggest or add new features

## Other Languages

Haikunator is also available in other languages. Check them out:

- Node: https://github.com/Atrox/haikunatorjs
- .NET: https://github.com/Atrox/haikunator.net
- Python: https://github.com/Atrox/haikunatorpy
- Java: https://github.com/Atrox/haikunatorjava
- Go: https://github.com/Atrox/haikunatorgo
- Clojure: https://github.com/Atrox/haikunatorclj
- Dart: https://github.com/Atrox/haikunatordart
- Ruby: https://github.com/usmanbashir/haikunator
- Rust: https://github.com/nishanths/rust-haikunator
