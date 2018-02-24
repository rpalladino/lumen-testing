<?php

use Example\Person\Person;
use Example\Person\PersonRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use PhpOption\Option;

class PersonRepositoryIntegrationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var PersonRepository
     */
    private $subject;

    public function setUp()
    {
        parent::setUp();

        $this->subject = new PersonRepository();
    }

    /**
     * @test
     */
    public function shouldSaveAndFetchPerson()
    {
        $peter = factory(Person::class)->create([
            'firstName' => 'Peter',
            'lastName'  => 'Pan'
        ]);

        $maybePeter = $this->subject->findByLastName("Pan");

        assertThat($maybePeter->isDefined(), is(true));
        assertThat($maybePeter->get()->firstName, is("Peter"));
    }
}
