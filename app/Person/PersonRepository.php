<?php

namespace Example\Person;

use PhpOption\Option;

class PersonRepository
{
    public function findByLastName(string $lastName) : Option
    {
        $maybePerson = Person::where('lastName', $lastName)->first();

        return Option::fromValue($maybePerson);
    }
}
