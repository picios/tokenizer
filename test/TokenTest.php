<?php

namespace Picios\Tokenizer\Test;

use PHPUnit\Framework\TestCase;
use Picios\Tokenizer\Token;

class TokenTest extends TestCase
{
    public function testToken()
    {
        $token = new Token(
            '45eb32', [
                'id' => 4
            ],
            new \DateTime()
        );
        $this->assertEquals(4, $token->get('id'));
    }

    public function testHash()
    {
        $token = new Token(
            '45eb32', [
                'id' => 4
            ],
            new \DateTime()
        );
        $this->assertEquals('45eb32', $token->getHash());
    }
}