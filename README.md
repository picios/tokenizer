

# Tokenizer

This library helps to create and validate url valid tokens and store some data within it. Such token can not be changed, otherwise it's not valid anymore.

## Installation

Install with composer

```
composer require picios/tokenizer
```
## Usage

### Creating a new token
You need to create the token first, to  e.g. send it as a query parameter in en email message

``` php
<?php

use Picios\Tokenizer\TokenManager;

require_once __DIR__ . '/vendor/autoload.php';
$tm = new TokenManager('seed', [
    'id', // information about fields, that the token will contain. In this case only 'id'
]);
$token = $tm->createToken([
    'id' => 5,
]);
// call token __toString() function
echo "{$token}";
```
### Parsing the token
Incoming token must be validated by the TokenManager::parse() function 
``` php
<?php

use Picios\Tokenizer\TokenManager;
use Picios\Tokenizer\TokenNotValidException;

require_once __DIR__ . '/vendor/autoload.php';

$tm = new TokenManager('seed', [
    'id', // information about fields, that the token will contain. In this case only 'id'
]);

// incoming token  e.g. from the Request::query object
// or just $_GET array
$stringToken = 'NDc5NWI4MjAxOS0wOC0wNlQwODozNjoxMCswMjowMHsiaWQiOjV9';

try {
    $token = $tm->parse($stringToken);
    echo "This is a secret content taken by token id {$token->get('id')}";
} catch (TokenNotValidException $e) {
    echo "Invalid token";
    exit();
}
```
### Creation time
You can easily check the token creation time to consider its expiration
``` php
<?php

use Picios\Tokenizer\TokenManager;
use Picios\Tokenizer\TokenNotValidException;

require_once __DIR__ . '/vendor/autoload.php';

$tm = new TokenManager('seed', [
    'id' // information about fields, that the token will contain. In this case only 'id'
]);

// incoming token  e.g. from the Request::query object
// or just $_GET array
$stringToken = 'NDc5NWI4MjAxOS0wOC0wNlQwODozNjoxMCswMjowMHsiaWQiOjV9';

try {
    $token = $tm->parse($stringToken);
    echo 'The token was created on ' . $token->getStartTime()->format('Y-m-d H:i:s');
} catch (TokenNotValidException $e) {
    echo "Invalid token";
    exit();
}
```

## How it works

The token allows you to store a limited amount of data in one string in a safe way. 

To create a new token, you need to get TokenManager object with parameters SEED and a structure of the data in token. It's a simple array with names of the token data fields. The SEED and the structure must be the same during creating the token and when you parse it.

When the TokenManager object is set, you may call its createToken(array data) function, of which the only required parameter is the associeted array with the data, you want to store in the token. The data array must contain exactly the same fields, as in the structure from the TokenManager object.

The data in the token are explicit, just encoded with base64 algorythm. They can be easly decoded. For the above example token
```
NDc5NWI4MjAxOS0wOC0wNlQwODozNjoxMCswMjowMHsiaWQiOjV9
```
a decoded string is
```
4795b82019-08-06T08:36:10+02:00{"id":5}
```
First 6 characters is a substring of a md5 hash created from all the data in the token plus the secret seed known only on the server side. The next 25 characters is a date of creating the token in ATOM format. The rest is the data encoded with the JSON format.

It's safety and unchangeability comes from the simple hash, that is a kind of a checksum of our token.

## Troubleshooting

- you need to remember that all the data in the token are easily decodable, so don't place any confidential data in it.
- the capacity of the token is limited to the purpose, you use it for. For example if you put it as a part of a URL query, according to the HTTP spec, there is no limit to a URL's length, but keep your URLs under 2048 characters so it would work well with IE browser.

## Testing

To test the class, run:
```
phpunit test
```
## Homepage

You can read more at [Picios.pl](http://picios.pl/)
