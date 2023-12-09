<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testConstruct()
    {
        $user = new User();
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
        $this->assertEquals(null, $user->getPseudo());
    }

    public function testGettersSetters()
    {
        $user = new User();

        $user->setFirstName('A');
        $this->assertEquals('A', $user->getFirstName());

        $user->setLastName('B');
        $this->assertEquals('B', $user->getLastName());

        $user->setPseudo('C');
        $this->assertEquals('C', $user->getPseudo());

        $user->setEmail('test@test.com');
        $this->assertEquals('test@test.com', $user->getEmail());
        $this->assertEquals('test@test.com', $user->getUserIdentifier());

        $user->setPlainPassword('pass');
        $this->assertEquals('pass', $user->getPlainPassword());

        $user->setPassword('pass');
        $this->assertEquals('pass', $user->getPassword());

        $user->setRoles(['A', 'B']);
        $this->assertEquals(['A', 'B', 'ROLE_USER'], $user->getRoles());
    }
}
