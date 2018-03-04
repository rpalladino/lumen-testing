<?php

use Example\Person\Person;
use Example\Person\PersonRepository;
use Example\Weather\WeatherClient;
use Example\Weather\WeatherResponse;
use PhpOption\Some;

define('OK', 200);

class ExampleControllerAPITest extends TestCase
{
    private $personRepository;
    private $weatherClient;

    public function setUp()
    {
        parent::setUp();

        $this->personRepository = Mockery::mock(PersonRepository::class);
        $this->weatherClient = Mockery::mock(WeatherClient::class);

        $this->app->instance(PersonRepository::class, $this->personRepository);
        $this->app->instance(WeatherClient::class, $this->weatherClient);
    }

    /**
     * @test
     */
    public function shouldReturnHelloWorld()
    {
        $response = $this->call('GET', '/hello');

        assertThat($response->status(), is(OK));
        assertThat($response->content(), containsString('Hello World!'));
    }

    /**
     * @test
     */
    public function shouldReturnFullName()
    {
        $this->personRepository->allows()
            ->findByLastName("Pan")
            ->andReturns(new Some(Person::named('Peter', 'Pan')));

        $response = $this->call('GET', '/hello/Pan');

        assertThat($response->status(), is(OK));
        assertThat($response->content(), containsString("Hello Peter Pan!"));
    }

    /**
     * @test
     */
    public function shouldReturnCurrentWeather()
    {
        $weatherResponse = new WeatherResponse("Partly cloudy");
        $this->weatherClient->allows()
            ->currentWeather()
            ->andReturns(new Some($weatherResponse));

        $response = $this->call('GET', '/weather');

        assertThat($response->status(), is(OK));
        assertThat($response->content(), containsString("Partly cloudy"));
    }
}
