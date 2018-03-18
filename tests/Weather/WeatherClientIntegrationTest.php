<?php

use Example\Helper\FileLoader;
use Example\Weather\WeatherClient;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Uri;
use PhpOption\Option;
use WireMock\Client\WireMock;

/**
 * @group wiremock
 * @group integration
 */
class WeatherClientIntegrationTest extends PHPUnit\Framework\TestCase
{
    /**
     * @var WeatherClient;
     */
    private $subject;

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

    public function setUp()
    {
        $url = getenv("WEATHER_SERVICE_URL");
        $this->subject = new WeatherClient(new HttpClient(), $url);
    }

    /**
     * @test
     */
    public function shouldCallWeatherService()
    {
        $path = $this->weatherServiceUri->getPath();
        $this->wireMock->stubFor(WireMock::get(WireMock::urlEqualTo($path))
            ->willReturn(WireMock::aResponse()
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->withBody(FileLoader::read(__DIR__.'/weatherApiResponse.json'))));

        $response = $this->subject->currentWeather();

         assertThat($response, is(anInstanceOf(PhpOption\Option::class)));
         assertThat($response->get()->getSummary(), is("Rain"));
    }
}
