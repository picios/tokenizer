<?php

namespace Picios\Tokenizer\Test;

use PHPUnit\Framework\TestCase;
use Picios\Tokenizer\TokenFormat;

class TokenFormatTest extends TestCase
{
    public function testEncode()
    {
        $this->assertEquals(
            'Hello World!', 
            TokenFormat::base64url_decode('SGVsbG8gV29ybGQh')
        );
    }

    public function testDecode()
    {
        $this->assertEquals(
            'SGVsbG8gV29ybGQh', 
            TokenFormat::base64url_encode('Hello World!')
        );
    }

}