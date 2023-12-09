<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_ADMIN", statusCode: 403, exceptionCode: 10010)]
class AdminController extends AbstractController
{

    #[Route('/admin', name: 'admin_home')]
    public function index(): Response
    {
        return $this->render('admin/home.html.twig');
    }
}
