<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Submission;
use App\Event\SubmissionEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SubmissionManager
{
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function create(Submission $submission, bool $autoFlush = true): Submission
    {
        if (!$this->entityManager->contains($submission)) {
            $this->entityManager->persist($submission);
        }
        $submission->setSubmittedAt(new \DateTime());
        if ($autoFlush) {
            $this->entityManager->flush();
        }
        $this->eventDispatcher->dispatch(
            new SubmissionEvent($submission),
            SubmissionEvent::SAVED
        );

        return $submission;
    }
}
