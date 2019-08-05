<?php

namespace Picios\Tokenizer;

use DateTime;
use DateTimeInterface;

/**
 * TokenFormat
 *
 * @author picios
 */
class TokenFormat
{

	static public function base64url_encode($data)
	{
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	static public function base64url_decode($data)
	{
		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
	}
	
	static public function dateToStr(DateTime $datetime)
	{
		return $datetime->format( DateTimeInterface::ATOM );
	}

}
