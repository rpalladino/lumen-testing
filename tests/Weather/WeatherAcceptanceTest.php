<?php

use Example\Helper\FileLoader;
use GuzzleHttp\Psr7\Uri;
use WireMock\Client\WireMock;

/**
 * @group wiremock
 * @group acceptance
 */
class WeatherAcceptanceTest extends TestCase
{
    /**
     * @var WireMock
     */
    private $wireMock;

    /**
     * Weather service URI
     * @var Uri
     */
    private $weatherServiceUri;

    /**
     * @before
     */
    public function setUpWireMock()
    {
        $this->weatherServiceUri = new Uri(getenv('WEATHER_SERVICE_URL'));

        $this->wireMock = WireMock::create(
            $this->weatherServiceUri->getHost(),
            $this->weatherServiceUri->getPort()
        );

        assertThat($this->wireMock->isAlive(), is(true));
    }

    /**
     * @test
     */
    public function shouldReturnCurrentWeather()
    {
        $path = $this->weatherServiceUri->getPath();
        $this->wireMock->stubFor(WireMock::get(WireMock::urlEqualTo($path))
            ->willReturn(WireMock::aResponse()
                ->withHeader('Content-Type', 'application/json')
                ->withBody(FileLoader::read(__DIR__.'/weatherApiResponse.json'))));

        $response = $this->call('GET', '/weather');

        assertThat($response->status(), is(200));
        assertThat($response->content(), containsString('Rain'));
    }
}
