<?php

use Illuminate\Database\Seeder;
use Example\Person\Person;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Person::class)->create([
            'firstName' => 'Peter',
            'lastName'  => 'Pan'
        ]);

        factory(Person::class)->create([
            'firstName' => 'Wendy',
            'lastName'  => 'Darling'
        ]);
    }
}
