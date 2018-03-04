<?php

use Giberti\PHPUnitLocalServer\LocalServerTestCase;
use GuzzleHttp\Client;

class HelloE2ERestTest extends LocalServerTestCase
{
    /**
     * @var Client
     */
    private $httpClient;

    public function setUp()
    {
        static::createServerWithDocroot(__DIR__.'/../public/');

        $this->httpClient = new Client([
            'base_uri' => $this->getLocalServerUrl()
        ]);
    }

    /**
     * @test
     */
    public function shouldReturnHelloWorld()
    {
        $response = $this->httpClient->request('GET', '/hello');

        assertThat($response->getStatusCode(), is(200));
        assertThat((string) $response->getBody(), containsString("Hello World!"));
    }
}
