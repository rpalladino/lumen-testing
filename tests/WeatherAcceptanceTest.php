<?php

use Example\Helper\FileLoader;
use WireMock\Client\WireMock;

class WeatherAcceptanceTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnCurrentWeather()
    {
        $weatherService = parse_url(getenv('WEATHER_SERVICE_URL'));

        $wireMock = WireMock::create(
            $weatherService['host'],
            $weatherService['port']
        );

        assertThat($wireMock->isAlive(), is(true));

        $path = $weatherService['path'];
        $wireMock->stubFor(WireMock::get(WireMock::urlEqualTo($path))
            ->willReturn(WireMock::aResponse()
                ->withHeader('Content-Type', 'application/json')
                ->withBody(FileLoader::read(__DIR__.'/Weather/weatherApiResponse.json'))));

        $response = $this->call('GET', '/weather');

        assertThat($response->status(), is(200));
        assertThat($response->content(), containsString('Rain'));
    }
}
