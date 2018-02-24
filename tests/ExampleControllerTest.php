<?php

use App\Http\Controllers\ExampleController;
use PHPUnit\Framework\TestCase;

class ExampleControllerTest extends TestCase
{
    private $subject;

    public function setUp()
    {
        $this->subject = new ExampleController();
    }

    /**
     * @test
     */
    public function shouldReturnHelloWorld()
    {
        assertThat($this->subject->hello(), is("Hello World!"));
    }
}
