<?php

namespace App\Tests\Unit\Entity;

use App\Entity\ContactMessage;
use App\Entity\ContactUser;
use PHPUnit\Framework\TestCase;

class ContactMessageTest extends TestCase
{
    public function testConstruct()
    {
        $message = new ContactMessage();
        $message->setMessage("Coucou");

        $this->assertEquals("Coucou", $message->getMessage());
        $this->assertEquals(false, $message->isProcessed());
        $this->assertNotNull($message->getCreatedAt());
    }

    public function testGettersSetters()
    {
        $contact = new ContactUser();
        $contact->setFirstname("prenom");
        $contact->setLastname("nom");
        $contact->setEmail("test@test.com");

        $message = new ContactMessage();
        $message->setMessage("Coucou");
        $this->assertEquals("Coucou", $message->getMessage());

        $message->setProcessed(true);
        $this->assertEquals(true, $message->isProcessed());

        $message->setContactUser($contact);
        $this->assertEquals($contact, $message->getContactUser());
    }
}