<?php

use WireMock\Client\WireMock;

class ExampleAcceptanceTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnCurrentWeather()
    {
        $wireMock = WireMock::create(
            getenv('WIREMOCK_HOST'),
            getenv('WIREMOCK_PORT')
        );

        assertThat($wireMock->isAlive(), is(true));

        $wireMock->stubFor(WireMock::get(WireMock::urlEqualTo('/weather'))
            ->willReturn(WireMock::aResponse()
                ->withHeader('Content-Type', 'application/json')
                ->withBody(file_get_contents(__DIR__.'/Weather/weatherApiResponse.json'))));

        $response = $this->call('GET', '/weather');

        assertThat($response->status(), is(200));
        assertThat($response->content(), containsString('Rain'));
    }
}
