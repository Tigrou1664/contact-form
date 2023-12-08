<?php

namespace App\DataFixtures;

use App\Entity\ContactMessage;
use App\Entity\ContactUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Contacts
        $contact1 = new ContactUser();
        $contact1->setFirstname('Jean')
            ->setLastname('Némard')
            ->setEmail('contact1@test.com');
        $manager->persist($contact1);

        $contact2 = new ContactUser();
        $contact2->setFirstname('Eli')
            ->setLastname('Coptère')
            ->setEmail('contact2@test.com');
        $manager->persist($contact2);

        $contact3 = new ContactUser();
        $contact3->setFirstname('Ola')
            ->setLastname('Kivala')
            ->setEmail('contact3@test.com');
        $manager->persist($contact3);

        // Messages with the same contact
        $message1 = new ContactMessage();
        $message1->setMessage('Comment appelle-t-on une chauve-souris avec une perruque ?')
            ->setContactUser($contact1);
        $manager->persist($message1);

        $message2 = new ContactMessage();
        $message2->setMessage('Réponse : Une souris')
            ->setContactUser($contact1);
        $manager->persist($message2);

        // Message alone
        $message3 = new ContactMessage();
        $message3->setMessage('Que fait une fraise sur un cheval ?')
            ->setContactUser($contact2);
        $manager->persist($message3);

        // Message alone
        $message4 = new ContactMessage();
        $message4->setMessage('Comment appelle-t-on un lapin sourd ?')
            ->setContactUser($contact3);
        $manager->persist($message4);

        $manager->flush();
    }
}
