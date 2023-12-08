<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    private const ADMIN_EMAIL = 'admin@test.fr';
    private const FROM_EMAIL = 'noreply@test.fr';

    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Service to send email
     */
    public function sendEmail($to = self::ADMIN_EMAIL, $subject = '', $content = '', $text = ''): void
    {
        $email = (new Email())
            ->from(self::FROM_EMAIL)
            ->to($to)
            ->subject($subject)
            ->text($text)
            ->html($content);
        $this->mailer->send($email);
    }
}