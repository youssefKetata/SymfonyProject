<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Email;
use function PHPUnit\Framework\throwException;

class MailerService
{
    private $replyTo;
    public function __construct(TransportInterface $transport, private readonly MailerInterface $mailer, $replyTo){

        $this->replyTo = $replyTo;

    }

    public function sendEmail($to='yusufketata5@gmail.com',
    $subject="Time for Symfony Mailer!",
    $text='Sending emails is fun again!',
    ):void{
        $mail = (new Email())
            ->from('yusufketata5@gmail.com')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            ->replyTo($this->replyTo)
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->text($text)
            ->html('<p>See Twig integration for better HTML integration!</p>');

        try {
            $this->mailer->send($mail);
        } catch (TransportExceptionInterface $e) {
            throw new \Exception('failed sending email');
        }
    }

}