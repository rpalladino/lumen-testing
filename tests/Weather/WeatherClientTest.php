<?php

use Example\Helper\FileLoader;
use Example\Weather\WeatherClient;
use Example\Weather\WeatherResponse;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PhpOption\Option;

class WeatherClientTest extends PHPUnit\Framework\TestCase
{
    const RESPONSE_FILE = __DIR__."/weatherApiResponse.json";

    /**
     * @var WeatherClient
     */
    private $subject;

    /**
     * @var HttpClient
     */
    private $httpClient;

    public function setUp()
    {
        $apiResponseJson =  FileLoader::read(self::RESPONSE_FILE);
        $httpClient = new HttpClient([
            'handler' => HandlerStack::create(
                new MockHandler([
                    new Response(200, [], $apiResponseJson)
                ])
            )
        ]);
        $this->subject = new WeatherClient($httpClient, '');
    }

    /**
     * @test
     */
    public function shouldCallWeatherService()
    {
        $maybeWeather = $this->subject->currentWeather();

        assertThat($maybeWeather instanceof Option, is(true));
        assertThat($maybeWeather->isDefined(), is(true));
        assertThat($maybeWeather->get()->getSummary(), is("Rain"));
    }
}
