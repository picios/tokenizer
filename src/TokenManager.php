<?php

namespace Picios\Tokenizer;

use DateTime;
use Exception;

/**
 * Description of TokenHasher
 *
 * @author picios
 */
class TokenManager
{

	/**
	 * Seed is a secret string not accessable from the app front
	 * eg. %^&%DSDSDSdsda%^d678435
	 * 
	 * @var string
	 */
	private $seed = null;

	/**
	 * Token data structure
	 * The data, which you want to store inside the token
	 * eg. ['userId', 'visitId', 'productId']
	 * 
	 * @var array 
	 */
	private $struct = [];

	/**
	 * Token checksum hash length
	 * 
	 * @var int 
	 */
	private $hashLength = 6;

	public function __construct(string $seed, array $struct)
	{
		$this->seed = $seed;
		$this->struct = $struct;
	}

	public function createToken(array $data, $time = null): Token
	{
		$datetime = $time ?? new \DateTime();
		$hash = $this->getHash($data, $datetime);
		$values = $this->getDataOrdered($data);
		$token = new Token($hash, $values, $datetime);
		return $token;
	}

	public function parse(string $string): Token
	{
		$plainData = TokenFormat::base64url_decode($string);
		try {
			$hash = substr($plainData, 0, $this->hashLength);
			$atomLen = strlen(date(\DateTimeInterface::ATOM, time()));
			$starttime = substr($plainData, $this->hashLength, $atomLen);
			$json = substr($plainData, $this->hashLength + $atomLen);
		} catch (\Exception $ex) {
			throw new TokenNotValidException('Not well formated string');
		}

		try {
			$data = json_decode($json, true);
		} catch (\Exception $ex) {
			throw new TokenNotValidException('String is undecodable');
		}

		if ($data === null) {
			throw new TokenNotValidException('String is undecodable');
		}

		try {
			$datettime = new \DateTime($starttime);
		} catch (\Exception $ex) {
			throw new TokenNotValidException('DateTime not corrected ' . $starttime);
		}

		$this->validateHash($hash, $data, $datettime);
		return new Token($hash, $data, $datettime);
	}

	private function validateHash(string $hash, array $data, \DateTime $datetime): bool
	{
		$tokenHash = $this->getHash($data, $datetime);
		if ($tokenHash != $hash) {
			throw new TokenNotValidException('Token not valid');
		}
		return true;
	}

	private function getHash(array $data, \DateTime $datetime): string
	{
		$values = $this->getDataOrdered($data);
		$hash = substr(md5(implode('', $values) . $datetime->format(\DateTimeInterface::ATOM) . $this->seed), 0, $this->hashLength);
		return $hash;
	}

	private function getDataOrdered(array $data): array
	{
		$values = [];
		foreach ($this->struct as $name) {
			if (!array_key_exists($name, $data)) {
				throw new TokenNotValidException('Can\'t construct the hash. Check data structure.');
			}
			$values[$name] = $data[$name];
		}
		return $values;
	}

}
