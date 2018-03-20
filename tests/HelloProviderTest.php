<?php

use GuzzleHttp\Psr7\Uri;
use PhpPact\Standalone\ProviderVerifier\Model\VerifierConfig;
use PhpPact\Standalone\ProviderVerifier\Verifier;
use PHPUnit\Framework\TestCase;

/**
 * @group contract
 * @medium
 */
class HelloProviderTest extends TestCase
{
    /**
     * @test
     */
    public function verifyPactFile()
    {
        $config = new VerifierConfig();
        $config
            ->setProviderName('person_provider')
            ->setProviderBaseUrl(new Uri(getenv('LOCAL_SERVER_URL')));

        $verifier = new Verifier($config);
        $verifier->verifyFiles([
            __DIR__.'/../resources/pact/person_consumer-person_provider.json'
        ]);
    }
}
