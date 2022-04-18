<?php

namespace App\Controller;

use App\Manager\PageManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class DashboardController extends AbstractController
{
    public function __construct(private PageManager $pageManager) {
    }

    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {

        $lastCreatedPages = $this->pageManager->getLastCreatedPages();

        return $this->render('dashboard/dashboard.html.twig', ['last_created_pages' => $lastCreatedPages]);
    }
}
