<?php

use Example\Person\Person;
use Example\Person\PersonRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;

/**
 * @group acceptance
 * @small
 */
class HelloAcceptanceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function shouldReturnHelloWorld()
    {
        $response = $this->call('GET', '/hello');

        assertThat($response->status(), is(200));
        assertThat($response->content(), containsString("Hello World!"));
    }

    /**
     * @test
     */
    public function shouldReturnGreeting()
    {
        Person::named('Peter', 'Pan')->save();

        $response = $this->call('GET', '/hello/Pan');

        assertThat($response->status(), is(200));
        assertThat($response->content(), containsString("Hello Peter Pan!"));
    }
}
