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

    /**
     * @var string
     */
    private $weatherServiceUrl;

    public function __construct(HttpClient $httpClient, string $weatherServiceUrl)
    {
        $this->httpClient = $httpClient;
        $this->weatherServiceUrl = $weatherServiceUrl;
    }

    public function currentWeather(): Option
    {
        $response = $this->httpClient
            ->request('GET', $this->weatherServiceUrl);

        $summary = json_decode($response->getBody())->currently->summary;
        $weatherResponse = new WeatherResponse($summary);

        return Option::fromValue($weatherResponse);
    }
}
