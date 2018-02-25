<?php

namespace App\Http\Controllers;

use Example\Person\PersonRepository;

class ExampleController extends Controller
{
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
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
        return;
    }
}
