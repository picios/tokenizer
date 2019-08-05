# Tokenizer

This library helps to create and validate url valid tokens and store some data within it. Such token can not be changed, otherwise it's not valid anymore.

## Installation

Install with composer

```
composer require picios/tokenizer
```
## Usage

``` php
require_once __DIR__ . '/vendor/autoload.php';

$tm = new Picios\Tokenizer\TokenManager('seed', [
    'id'
]);

$token->createToken([
    'id' => 5,
]);

echo "{$token}";
```

## Testing

To test the class, run:

```
phpunit test
```

## Homepage

You can read more at [Picios.pl](http://picios.pl/)