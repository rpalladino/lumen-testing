<?php

namespace Example\Weather;

use GuzzleHttp\Client as HttpClient;
use PhpOption\Option;

class WeatherClient
{
	/**
	 * @var HttpClient
	 */
	private $httpClient;

	public function __construct(HttpClient $httpClient)
	{
		$this->httpClient = $httpClient;
	}

	public function currentWeather(): Option
	{
		$response = $this->httpClient->request('GET', '/weather');

		$summary = json_decode($response->getBody())->currently->summary;
		$weatherResponse = new WeatherResponse($summary);

		return Option::fromValue($weatherResponse);
	}
}
