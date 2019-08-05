<?php

namespace Picios\Tokenizer;

use DateTime;

/**
 * Description of OfficeHasherToken
 *
 * @author picios
 */
class Token
{

	/**
	 *
	 * @var array 
	 */
	private $data;

	/**
	 *
	 * @var string 
	 */
	private $hash;
	
	/**
	 *
	 * @var DateTime 
	 */
	private $startTime;

	public function __construct(string $hash, array $data, DateTime $startTime)
	{
		$this->hash = $hash;
		$this->data = $data;
		$this->startTime = $startTime;
	}

	public function getHash()
	{
		return $this->hash;
	}

	public function setHash($hash)
	{
		$this->hash = $hash;
		return $this;
	}
	
	public function get($name, $default = null)
	{
		return $this->data[$name] ?? $default;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}
	
	public function getStartTime(): DateTime
	{
		return $this->startTime;
	}

	public function setStartTime(DateTime $startTime)
	{
		$this->startTime = $startTime;
		return $this;
	}

	public function __toString()
	{
		return TokenFormat::base64url_encode($this->getHash() . TokenFormat::dateToStr($this->getStartTime()) . $this->dataToString());
	}

	private function dataToString()
	{
		return json_encode($this->data);
	}

}
