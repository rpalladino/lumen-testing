<?php

use App\Http\Controllers\ExampleController;
use Example\Person\Person;
use Example\Person\PersonRepository;
use PhpOption\Some;
use PHPUnit\Framework\TestCase;

class ExampleControllerTest extends TestCase
{
    private $subject;
    private $personRepository;

    public function setUp()
    {
        $this->personRepository = Mockery::mock(PersonRepository::class);
        $this->subject = new ExampleController($this->personRepository);
    }

    /**
     * @test
     */
    public function shouldReturnHelloWorld()
    {
        assertThat($this->subject->hello(), is("Hello World!"));
    }

    /**
     * @test
     */
    public function shouldReturnFullNameOfAPerson()
    {
        $peter = new Person();
        $peter->firstName = "Peter";
        $peter->lastName = "Pan";

        $this->personRepository->allows()
             ->findByLastName("Pan")
             ->andReturns(new Some($peter));

        $greeting = $this->subject->helloPerson("Pan");

        assertThat($greeting, is("Hello Peter Pan!"));
    }
}
