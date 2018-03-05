<?php

use GuzzleHttp\Psr7\Uri;
use PhpPact\Standalone\ProviderVerifier\Model\VerifierConfig;
use PhpPact\Standalone\ProviderVerifier\Verifier;
use PHPUnit\Framework\TestCase;

/**
 * @group contract
 */
class ExampleProviderTest extends TestCase
{
    /**
     * @test
     */
    public function verifyPactFile()
    {
        $config = new VerifierConfig();
        $config
            ->setProviderName('person_provider')
            ->setProviderBaseUrl(new Uri('http://localhost:8000'));

        $verifier = new Verifier($config);
        $verifier->verifyFiles([
            __DIR__.'/../resources/pact/person_consumer-person_provider.json'
        ]);
    }
}
