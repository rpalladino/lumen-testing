<?php

namespace Example\Person;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public static function named(string $firstName, string $lastName)
    {
        $person = new self;
        $person->firstName = $firstName;
        $person->lastName = $lastName;

        return $person;
    }

    public function getFirstName() : string
    {
        return $this->firstName;
    }

    public function getLastName() : string
    {
        return $this->lastName;
    }
}
