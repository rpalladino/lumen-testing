<?php

use Facebook\WebDriver\WebDriverBy as By;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\TestCase;

/**
 * @group selenium
 */
class HelloE2ESeleniumTest extends TestCase
{
    /**
     * @var RemoteWebDriver
     */
    private $driver;

    public function setUp()
    {
        $this->driver = RemoteWebDriver::create(
            getenv('SELENIUM_SERVER_URL'),
            DesiredCapabilities::chrome()
        );
    }

    /**
     * @test
     */
    public function helloPageHasTextHelloWorld()
    {
        $this->driver->get('http://localhost:8000/hello');

        $body = $this->driver->findElement(By::tagName('body'));

        assertThat($body->getText(), containsString("Hello World!"));
    }

    public function tearDown()
    {
        $this->driver->quit();
    }
}
