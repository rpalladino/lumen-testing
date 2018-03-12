<?php

use Example\Helper\FileLoader;
use Example\Weather\WeatherClient;
use GuzzleHttp\Client;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServerEnvConfig;
use PHPUnit\Framework\TestCase;

/**
 * @group contract
 * @medium
 */
class WeatherClientConsumerTest extends TestCase
{
    const WEATHER_URL = '/forecast/some-api-key/53.5511,9.9937';

    /**
     * @var MockServerEnvConfig
     */
    private $config;

    /**
     * @var InteractionBuilder
     */
    private $pact;

    /**
     * Create the pact between consumer and provider
     *
     * @before
     */
    public function createPact()
    {
        $this->config  = new MockServerEnvConfig();
        $this->pact = new InteractionBuilder($this->config);
        $this->pact
            ->given("Weather forecast data")
            ->uponReceiving("A request for a forecast")
            ->with((new ConsumerRequest())
                ->setMethod('GET')
                ->setPath(self::WEATHER_URL)
            )
            ->willRespondWith((new ProviderResponse())
                ->setStatus(200)
                ->setBody(FileLoader::read(__DIR__.'/weatherApiResponse.json'))
            );
    }

    /**
     * @test
     */
    public function shouldFetchCurrentWeatherInformation()
    {
        // Create the weather client consumer
        $httpClient = new Client(['base_uri' => $this->config->getBaseUri()]);
        $weatherClient = new WeatherClient($httpClient, self::WEATHER_URL);

        // Make request against the mock weather service
        $weatherResponse = $weatherClient->currentWeather();

        // Verify that interactions defined in the pact took place
        $this->pact->verify();

        assertThat($weatherResponse->isDefined(), is(true));
        assertThat($weatherResponse->get()->getSummary(), is("Rain"));
    }
}
