<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Entity\ContactUser;
use App\Form\ContactMessageType;
use App\Services\MessageToJsonService;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(
        Request $request,
        EntityManagerInterface $manager,
        MailerService $mailer,
        MessageToJsonService $messageToJson,
        LoggerInterface $logger,
        TranslatorInterface $translator
    ): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactMessage = $form->getData();

            // Check if user exists (find by email)
            $contactUser = $manager->getRepository(ContactUser::class)->findOneBy(['email' => $contactMessage->getContactUser()->getEmail()]);

            // If exists we link it to the message
            if ($contactUser !== null) {
                $contactMessage->setContactUser($contactUser);
            }

            // Save in database
            $manager->persist($contactMessage);
            $manager->flush();

            // Save mesage to json
            $messageToJson->save($contactMessage);

            // Send email to admin
            $mailer->sendEmail(
                subject: $translator->trans('mailer.subject', [
                    '%email%' => $contactMessage->getContactUser()->getEmail(),
                ]),
                content: $translator->trans('mailer.content', [
                    '%name%' => $contactMessage->getContactUser()->getFullname(),
                ]) . $contactMessage->getMessage()
            );

            flash()->addSuccess($translator->trans('flash.message.send.success'));

            return $this->redirectToRoute('app_home');
        }
        return $this->render('pages/home.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
