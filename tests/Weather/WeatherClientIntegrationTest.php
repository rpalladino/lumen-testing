<?php

use Example\Weather\WeatherClient;
use GuzzleHttp\Client as HttpClient;
use PhpOption\Option;
use WireMock\Client\WireMock;

class WeatherClientIntegrationTest extends PHPUnit\Framework\TestCase
{
    /**
     * @var WeatherClient;
     */
    private $subject;

    /**
     * Parsed weather service url
     * @var array
     */
    private $weatherService;

    public function setUp()
    {
        $url = getenv('WEATHER_SERVICE_URL');
        $this->weatherService = parse_url($url);
        $this->wireMock = WireMock::create(
            $this->weatherService['host'],
            $this->weatherService['port']
        );

        $this->subject = new WeatherClient(new HttpClient(), $url);
    }

    /**
     * @test
     */
    public function shouldCallWeatherService()
    {
        $path = $this->weatherService['path'];
        $this->wireMock->stubFor(WireMock::get(WireMock::urlEqualTo($path))
            ->willReturn(WireMock::aResponse()
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->withBody(file_get_contents(__DIR__.'/weatherApiResponse.json'))));

        $response = $this->subject->currentWeather();

         assertThat($response, is(anInstanceOf(PhpOption\Option::class)));
         assertThat($response->get()->getSummary(), is("Rain"));
    }
}
