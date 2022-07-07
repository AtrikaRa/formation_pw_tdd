<?php
namespace App\Tests\Integration;

use App\Entity\ContactData;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\ContactDataRepository;

class SaveContactControllerTest extends WebTestCase
{
    public function testDatabaseInsert()
    {
        // (1) boot the Symfony kernel
        self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();
        $em = $container->get('doctrine.orm.entity_manager');

        $this->assertEquals(true, false);
    }

    public function testSendEmailContactPage() {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/contact');

        $this->assertSelectorTextContains('h1', 'Nous contacter');

        $form = $crawler->selectButton("Save")->form([
            "contact[nom]" => "janne",
            "contact[email]" => "janneDoe@mail.com",
            "contact[message]" => "Hello"
        ]);

        $client->submit($form);

        $contactRepository = static::getContainer()->get(ContactDataRepository::class);

        // retrieve the test user
        $testUser = $contactRepository->findBy([
            "email" => "janneDoe@mail.com",
            "nom" => "janne",
            "message" => "Hello"
        ]);

        $this->assertGreaterThanOrEqual(1, count($testUser));

    }
}