<?php

namespace Picios\Tokenizer\Test;

use PHPUnit\Framework\TestCase;
use Picios\Tokenizer\TokenManager;
use Picios\Tokenizer\TokenNotValidException;

class TokenManagerTest extends TestCase
{
    /**
     * create new token
     */
    public function testCreate()
    {
        $tm = new TokenManager('123', [ 'id' ]);
        $token = $tm->createToken([ 'id' => 5 ]);
        $this->assertEquals(
            5, 
            $token->get('id')
        );
    }

    /**
     * valid parse
     */
    public function testParse()
    {
        $tm = new TokenManager('123', [ 'id' ]);
        $token = $tm->parse('MDYwY2IwMjAxOS0wOC0wNVQxMTozMzowNyswMjowMHsiaWQiOjV9');
        $this->assertEquals(
            5, 
            $token->get('id')
        );
    }

    /**
     * invalid parse
     */
    public function testInvalid()
    {
        $tm = new TokenManager('123', [ 'id' ]);
        $this->expectException(TokenNotValidException::class);
        $token = $tm->parse('Fake token string');
    }

}