<?php

use App\Http\Controllers\ExampleController;
use Example\Person\Person;
use Example\Person\PersonRepository;
use Example\Weather\WeatherClient;
use Example\Weather\WeatherResponse;
use PhpOption\Some;
use PhpOption\None;
use PHPUnit\Framework\TestCase;

class ExampleControllerTest extends TestCase
{
    private $subject;
    private $personRepository;
    private $weatherClient;

    public function setUp()
    {
        $this->personRepository = Mockery::mock(PersonRepository::class);
        $this->weatherClient = Mockery::mock(WeatherClient::class);

        $this->subject = new ExampleController(
            $this->personRepository,
            $this->weatherClient
        );
    }

    /**
     * @test
     */
    public function shouldReturnHelloWorld()
    {
        assertThat($this->subject->hello(), is("Hello World!"));
    }

    /**
     * @test
     */
    public function shouldReturnFullNameOfAPerson()
    {
        $this->personRepository->allows()
             ->findByLastName("Pan")
             ->andReturns(new Some(Person::named('Peter', 'Pan')));

        $greeting = $this->subject->helloPerson("Pan");

        assertThat($greeting, is("Hello Peter Pan!"));
    }

    /**
     * @test
     */
    public function shouldTellIfPersonIsUnknown()
    {
        $this->personRepository->allows()
             ->findByLastName(anything())
             ->andReturns(None::create());

        $greeting = $this->subject->helloPerson("Pan");

        assertThat($greeting, is("Who is this 'Pan' you're talking about?"));
    }

    /**
     * @test
     */
    public function shouldCallWeatherClient()
    {
        $current = "Hamburg, 8°C raining";
        $this->weatherClient
            ->allows()
                ->currentWeather()
                ->andReturns(new Some(new WeatherResponse($current)));

        $weather = $this->subject->weather();

        assertThat($weather, is($current));
    }

    /**
     * @test
     */
    public function shouldReturnErrorMessageIfWeatherIsUnavailable()
    {
        $this->weatherClient->allows()
            ->currentWeather()
            ->andReturns(None::create());

        $weather = $this->subject->weather();

        assertThat($weather, is("Sorry, I couldn't fetch the weather for you :("));
    }
}
