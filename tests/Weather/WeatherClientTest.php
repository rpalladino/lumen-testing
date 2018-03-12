<?php

use Example\Helper\FileLoader;
use Example\Weather\WeatherClient;
use Example\Weather\WeatherResponse;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use PhpOption\Option;

/**
 * @group unit
 * @small
 */
class WeatherClientTest extends PHPUnit\Framework\TestCase
{
    const RESPONSE_FILE = __DIR__."/weatherApiResponse.json";

    /**
     * @test
     */
    public function shouldCallWeatherService()
    {
        $apiResponseJson =  FileLoader::read(self::RESPONSE_FILE);
        $httpClient = new HttpClient([
            'handler' => HandlerStack::create(
                new MockHandler([
                    new Response(200, [], $apiResponseJson)
                ])
            )
        ]);
        $subject = new WeatherClient($httpClient, '/');

        $maybeWeather = $subject->currentWeather();

        assertThat($maybeWeather instanceof Option, is(true));
        assertThat($maybeWeather->isDefined(), is(true));
        assertThat($maybeWeather->get()->getSummary(), is("Rain"));
    }

    /**
     * @test
     */
    public function shouldReturnEmptyOptionalIfWeatherServiceIsUnavailable()
    {
        $httpClient = new HttpClient([
            'handler' => HandlerStack::create(
                new MockHandler([
                    new RequestException("Something went wrong", new Request('GET', '/'))
                ])
            )
        ]);
        $subject = new WeatherClient($httpClient, '/');

        $response = $subject->currentWeather();

        assertThat($response->isEmpty(), is(true));

    }
}
