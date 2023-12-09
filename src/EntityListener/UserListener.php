<?php

namespace App\EntityListener;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
    private LoggerInterface $logger;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(LoggerInterface $logger, UserPasswordHasherInterface $passwordHasher)
    {
        $this->logger = $logger;
        $this->passwordHasher = $passwordHasher;
    }
    public function prePersist(User $user)
    {
        $this->logger->info('Creating a new user...', [
            'fullname' => $user->getFullname(),
            'email' => $user->getEmail(),
        ]);
        $this->encodePassword($user);
    }

    public function preUpdate(User $user)
    {
        $this->encodePassword($user);
    }

    /**
     * Encode password based on plain password
     * 
     * @param User $user
     * @return void
     */
    public function encodePassword(User $user)
    {
        if ($user->getPlainPassword() === null) {
            return;
        }

        $encoded = $this->passwordHasher->hashPassword(
            $user,
            $user->getPlainPassword()
        );

        $this->logger->info('Hashing ' . $user->getEmail() . "'s plain password.");
        $user->setPassword($encoded);
        $user->setPlainPassword(null);
    }
}