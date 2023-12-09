<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Entity\ContactUser;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted("ROLE_ADMIN", statusCode: 403, exceptionCode: 10010)]
class AdminController extends AbstractController
{
    private LoggerInterface $logger;
    private TranslatorInterface $translator;
    private EntityManagerInterface $entityManager;
    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager, TranslatorInterface $translator)
    {
        $this->logger = $logger;
        $this->translator = $translator;
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin_home')]
    public function index(): Response
    {
        return $this->redirectToRoute('admin_inbox');
    }

    /**
     * List contacts
     */
    #[Route('/admin/inbox/contacts', name: 'admin_inbox')]
    public function listContacts(): Response
    {
        // List all contacts
        $contacts = $this->entityManager->getRepository(ContactUser::class)->findBy([], ['createdAt' => 'DESC']);

        // Get message of the first contact
        $messages = $contacts[0]->getMessages();

        return $this->render('admin/messages.html.twig', [
            'currentContact' => $contacts[0]->getId(),
            'contacts' => $contacts,
            'messages' => $messages,
        ]);
    }

    /**
     * List messages
     */
    #[Route('/admin/inbox/contacts/{id}/messages', name: 'admin_list_message')]
    public function listMessages(int $id): Response
    {
        // List all contacts
        $contacts = $this->entityManager->getRepository(ContactUser::class)->findBy([], ['createdAt' => 'DESC']);

        // Get the contact by id
        $messages = $this->entityManager->getRepository(ContactMessage::class)->findBy(['contactUser' => $id], ['createdAt' => 'ASC']);

        return $this->render('admin/messages.html.twig', [
            'currentContact' => $id,
            'contacts' => $contacts,
            'messages' => $messages,
        ]);
    }

    /**
     * Mark message as processed
     */
    #[Route('/admin/inbox/contacts/{id}/messages/{messageId}/process', name: 'admin_message_process', methods: ['GET'])]
    public function setMessageAsProcessed(int $id, int $messageId): Response
    {
        $message = $this->entityManager->getRepository(ContactMessage::class)->find($messageId);

        if (!$message) {
            return new JsonResponse('Messages not found', 404);
        }

        $message->setProcessed(!$message->isProcessed());

        $this->entityManager->persist($message);
        $this->entityManager->flush();

        $this->logger->info('[Message update] - set message as processed', [
            'id' => $message->getId(),
            'processed' => $message->isProcessed(),
        ]);

        flash()->addSuccess($this->translator->trans('flash.message.update.success'));

        return $this->redirectToRoute('admin_list_message', [
            'id' => $id,
        ]);
    }
}
