<?php

namespace App\Tests\Unit\Entity;

use App\Entity\ContactMessage;
use App\Entity\ContactUser;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class ContactUserTest extends TestCase
{
    public function testConstruct()
    {
        $contact = new ContactUser();
        $contact->setFirstname("A");
        $contact->setLastname("B");
        $contact->setEmail("test@test.com");

        $this->assertEquals("A", $contact->getFirstName());
        $this->assertEquals("B", $contact->getLastName());
        $this->assertEquals("test@test.com", $contact->getEmail());
        $this->assertNotNull($contact->getCreatedAt());
        $this->assertEquals(new ArrayCollection(), $contact->getMessages());
    }
    public function testGettersSetters()
    {
        $contact = new ContactUser();
        $contact->setFirstname("A");
        $this->assertEquals("A", $contact->getFirstname());

        $contact->setLastname("B");
        $this->assertEquals("B", $contact->getLastname());
        $this->assertEquals("A B", $contact->getFullname());

        $contact->setEmail("test@test.com");
        $this->assertEquals("test@test.com", $contact->getEmail());

        $date = new \DateTimeImmutable();
        $contact->setCreatedAt($date);
        $this->assertEquals($date, $contact->getCreatedAt());

        $message = new ContactMessage();
        $message->setMessage("Coucou");

        $contact->addMessage($message);
        $this->assertIsObject($contact->getMessages());
        $this->assertEquals($contact, $message->getContactUser());
    }
}