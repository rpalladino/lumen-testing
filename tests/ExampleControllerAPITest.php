<?php

use Example\Person\Person;
use Laravel\Lumen\Testing\DatabaseMigrations;

define('OK', 200);

class ExampleControllerAPITest extends TestCase
{
    use DatabaseMigrations;

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
        factory(Person::class)->create([
            'firstName' => 'Peter',
            'lastName'  => 'Pan'
        ]);

        $response = $this->call('GET', '/hello/Pan');

        assertThat($response->status(), is(OK));
        assertThat($response->content(), containsString("Hello Peter Pan!"));
    }

    /**
     * @test
     */
    public function shouldReturnCurrentWeather()
    {
        $response = $this->call('GET', '/weather');

        assertThat($response->status(), is(OK));
    }
}
