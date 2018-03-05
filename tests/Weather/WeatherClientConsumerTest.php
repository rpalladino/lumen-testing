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
 */
class WeatherClientConsumerTest extends TestCase
{
    const WEATHER_URL = '/forecast/some-api-key/53.5511,9.9937';

    /**
     * @test
     */
    public function shouldFetchCurrentWeatherInformation()
    {
        // Create request expected from the weather client
        $request = new ConsumerRequest();
        $request
            ->setMethod('GET')
            ->setPath(self::WEATHER_URL);

        // Create response expected from the weather service
        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->setBody(FileLoader::read(__DIR__.'/weatherApiResponse.json'));

        // Create the pact between consumer and provider
        $config  = new MockServerEnvConfig();
        $builder = new InteractionBuilder($config);
        $builder
            ->given("Weather forecast data")
            ->uponReceiving("A request for a forecast")
            ->with($request)
            ->willRespondWith($response);

        // Create the weather client consumer
        $httpClient = new Client(['base_uri' => $config->getBaseUri()]);
        $weatherClient = new WeatherClient($httpClient, self::WEATHER_URL);

        // Make request against the mock weather service
        $weatherResponse = $weatherClient->currentWeather();

        // Verify that interactions defined in the pact took place
        $builder->verify();

        assertThat($weatherResponse->isDefined(), is(true));
        assertThat($weatherResponse->get()->getSummary(), is("Rain"));
    }
}
