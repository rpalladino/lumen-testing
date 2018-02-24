<?php

class ExampleControllerAPITest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnHelloWorld()
    {
        $response = $this->call('GET', '/hello');

        assertThat($response->status(), is(200));
        assertThat($response->content(), containsString('Hello World!'));
    }
}
