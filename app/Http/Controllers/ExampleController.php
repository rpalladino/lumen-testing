<?php

namespace App\Http\Controllers;

use Example\Person\PersonRepository;
use Example\Weather\WeatherClient;

class ExampleController extends Controller
{
    /**
     * @var PersonRepository
     */
    private $personRepository;

    /**
     * @var WeatherClient
     */
    private $weatherClient;

    public function __construct(PersonRepository $personRepository, WeatherClient $weatherClient)
    {
        $this->personRepository = $personRepository;
        $this->weatherClient = $weatherClient;
    }

    public function hello() : string
    {
        return "Hello World!";
    }

    public function helloPerson(string $lastName) : string
    {
        $foundPerson = $this->personRepository->findByLastName($lastName);

        return $foundPerson
            ->map(function ($person) {
                return "Hello {$person->firstName} {$person->lastName}!";
            })
            ->getOrElse("Who is this '{$lastName}' you're talking about?");
    }

    public function weather()
    {
        return $this->weatherClient->currentWeather();
    }
}
