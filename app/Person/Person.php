<?php

namespace Example\Person;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public function getFirstName() : string
    {
        return $this->firstName;
    }

    public function getLastName() : string
    {
        return $this->lastName;
    }
}
