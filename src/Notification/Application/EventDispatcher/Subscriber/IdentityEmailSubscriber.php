<?php

namespace Poposki\Notification\Application\EventDispatcher\Subscriber;

use Poposki\Identity\Application\EventDispatcher\PasswordResetRequestedEvent;
use Poposki\Kernel\Application\EventDispatcher\EventSubscriberInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

final readonly class IdentityEmailSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private MailerInterface $mailer
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            PasswordResetRequestedEvent::class => 'onPasswordResetRequested',
        ];
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function onSignUpSuccess($event)
    {
        $verifyEmailRouteName = 'app_verify_email';
        $user = $event->getUser();

        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            $user->getId(),
            $user->getEmail(),
            ['id' => $user->getId()]
        );

        $email = (new TemplatedEmail())
            ->from(new Address('development@example.com', 'Poposki'))
            ->to($user->getEmail())
            ->subject('Please Confirm your Email')
            ->htmlTemplate('notification/identity/confirmation_email.html.twig')
            ->context([
                'signedUrl' => $signatureComponents->getSignedUrl(),
                'expiresAtMessageKey' => $signatureComponents->getExpirationMessageKey(),
                'expiresAtMessageData' => $signatureComponents->getExpirationMessageData(),
            ]);

        $this->mailer->send($email);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function onPasswordResetRequested(PasswordResetRequestedEvent $event): void
    {
        $email = (new TemplatedEmail())
            ->to($event->getEmail())
            ->subject('Reset your account password')
            ->htmlTemplate('notification/identity/password_forgot.html.twig')
            ->context([
                'token' => $event->getToken(),
            ]);

        $this->mailer->send($email);
    }
}
