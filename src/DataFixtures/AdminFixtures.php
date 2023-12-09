<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        // Generate an admin
        $user = new User();
        $user->setFirstname('Fred')
            ->setLastname('Dumas')
            ->setPseudo('Admin')
            ->setEmail('admin@test.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPlainPassword('password');

        $manager->persist($user);

        $manager->flush();
    }
}
