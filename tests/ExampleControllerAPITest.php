<?php

use Example\Person\Person;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ExampleControllerAPITest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function shouldReturnHelloWorld()
    {
        $response = $this->call('GET', '/hello');

        assertThat($response->status(), is(200));
        assertThat($response->content(), containsString('Hello World!'));
    }

    /**
     * @test
     */
    public function shouldReturnFullName()
    {
        factory(Person::class)->create([
            'firstName' => 'Peter',
            'lastName'  => 'Pan'
        ]);

        $response = $this->call('GET', '/hello/Pan');

        assertThat($response->status(), is(200));
        assertThat($response->content(), containsString("Hello Peter Pan!"));
    }
}
