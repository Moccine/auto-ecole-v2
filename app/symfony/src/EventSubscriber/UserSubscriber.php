<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\Order;
use App\Entity\Token;
use App\Event\UserEvent;
use App\EventSubscriber\Traits\LetterTrait;
use App\Manager\UserManager;
use App\Service\Mailer\Sender;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private Sender $sender;

    private UserManager $userManager;

    private UrlGeneratorInterface $urlGenerator;

    private EntityManagerInterface $em;

    private SessionInterface $session;

    use LetterTrait;

    public function __construct(
        Sender $sender,
        UserManager $userManager,
        RouterInterface $router,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager,
        SessionInterface $session
    ) {
        $this->sender = $sender;
        $this->userManager = $userManager;
        $this->urlGenerator = $urlGenerator;
        $this->em = $entityManager;
        $this->session = $session;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserEvent::REGISTERED => 'onRegistered',
            UserEvent::REGISTERED_CONFIRMED => 'onRegisteredConfirmed',
            UserEvent::LOGGED => 'onLogged',
            UserEvent::RESETED => 'onReseted',
        ];
    }

    public function onRegistered(UserEvent $event): void
    {
        $token = $this->em->getRepository(Token::class)->findOneBy([
           'user' => $event->getUser(),
           'type' => Token::TYPE_CONFIRM,
        ]);

        $letter = $this->getLetterInfo(UserEvent::REGISTERED);
         $to= $event->getUser()->getEmail();
         $subject = 'Confirm';
         $content = 'le contenu' . $this->urlGenerator->generate('registration_confirm', ['value' => $token->getValue()]);
         $bindings = [];
         $attachments = [];
        $this->sender->deliver($to, $subject, $content, $bindings, $attachments);

            /*        if ($letter) {
            $this->sender->deliver(
                $event->getUser()->getEmail(),
                $letter->getSubject(),
                $letter->getContent(),
                ['url' => $this->urlGenerator->generate('registration_confirm', ['value' => $token->getValue()])],
                []
            );
        }*/
    }

    public function onRegisteredConfirmed(UserEvent $event): void
    {
        $event->getUser()->setEnabled(true);

        $this->em->flush();

        $letter = $this->getLetterInfo(UserEvent::REGISTERED_CONFIRMED);
        $to= $event->getUser()->getEmail();
        $subject = 'Confirm';
        $content = 'le contenu i';
        $bindings = [];
        $attachments = [];
        $this->sender->deliver($to, $subject, $content, $bindings, $attachments);
     /*   $this->sender->deliver(
            $event->getUser()->getEmail(),
            $letter->getSubject(),
            $letter->getContent(),
            [],
            []
        );*/
    }

    public function onLogged(UserEvent $event): void
    {
        $user = $event->getUser();
        $client = $user->getClient();

        $order = $this->em->getRepository(Order::class)->findOneBy(['client' => $client, 'status' => Order::STATUS_PENDING], ['id' => 'DESC']);

        if ($order) {
            $this->session->set('latest_pending_order', $order->getId());
        }
    }

    public function onReseted(UserEvent $event): void
    {
        $user = $event->getUser();

        $letter = $this->getLetterInfo(UserEvent::RESETED);

        $this->sender->deliver(
            $user->getEmail(),
            $letter->getSubject(),
            $letter->getContent(),
            ['url' => $this->urlGenerator->generate('user_reset', ['token' => $this->userManager->getTokenByUser($user)])],
            []
        );
    }
}
