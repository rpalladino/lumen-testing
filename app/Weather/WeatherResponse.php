<?php

namespace Example\Weather;

class WeatherResponse
{
	private $summary;

	public function __construct(string $summary)
	{
		$this->summary = $summary;
	}

	public function getSummary() : string
	{
		return $this->summary;
	}
}
