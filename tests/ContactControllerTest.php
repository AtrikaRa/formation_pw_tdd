<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class ContactControllerTest extends PantherTestCase
{

    public function testInvalidUsernameContactPage() {
        $client = static::createPantherClient([
            "hostname" => "127.0.0.1",
            "port" => "9992"
        ]);
        
        $crawler = $client->request('GET', '/contact');

        $this->assertSelectorTextContains('h1', 'Nous contacter');

        $form = $crawler->selectButton("Save")->form([
            "contact[nom]" => "",
            "contact[email]" => "janneDoe@domain.com",
            "contact[message]" => "Hello"
        ]);

        $client->submit($form);

        $this->assertSelectorTextContains('.invalid-feedback', 'Nom invalide');
    }

    public function testInvalidEmailContactPage() {
        $client = static::createPantherClient([
            "hostname" => "127.0.0.1",
            "port" => "9993"
        ]);
        
        $crawler = $client->request('GET', '/contact');

        $this->assertSelectorTextContains('h1', 'Nous contacter');

        $form = $crawler->selectButton("Save")->form([
            "contact[nom]" => "janne",
            "contact[email]" => "janneDoe",
            "contact[message]" => "Hello"
        ]);

        $client->submit($form);

        $this->assertSelectorTextContains('.invalid-feedback', 'Email invalides');
    }

    public function testInvalidMessageContactPage() {
        $client = static::createPantherClient([
            "hostname" => "127.0.0.1",
            "port" => "9992"
        ]);
        
        $crawler = $client->request('GET', '/contact');

        $this->assertSelectorTextContains('h1', 'Nous contacter');

        $form = $crawler->selectButton("Save")->form([
            "contact[nom]" => "janne",
            "contact[email]" => "janneDoe@mail.com",
            "contact[message]" => ""
        ]);

        $client->submit($form);

        $this->assertSelectorTextContains('.invalid-feedback', 'Message invalide');
    }

    public function testSendEmailContactPage() {
        $client = static::createPantherClient([
            "hostname" => "127.0.0.1",
            "port" => "9992"
        ]);
        
        $crawler = $client->request('GET', '/contact');

        $this->assertSelectorTextContains('h1', 'Nous contacter');

        $form = $crawler->selectButton("Save")->form([
            "contact[nom]" => "janne",
            "contact[email]" => "janneDoe@mail.com",
            "contact[message]" => "Hello"
        ]);

        $client->submit($form);

        $this->assertSelectorTextContains('.alert-success', 'Vore message a été envoyé');
    }
}
