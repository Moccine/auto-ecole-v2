<?php

declare(strict_types=1);

namespace App\Service\Mailer;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Sender implements SenderInterface
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function deliver(
        string $to,
        string $subject,
        string $content,
        ?array $bindings,
        ?array $attachments
    ): void {
        $email = new Email();

        $email->from('email@kernix.com');
        $email->to($to);
        $email->subject($subject);
        $email->html(SenderHelper::bind($content, $bindings));

        $this->mailer->send($email);
    }
}
