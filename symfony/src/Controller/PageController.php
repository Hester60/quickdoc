<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\PageParameter;
use App\Entity\Todo;
use App\Entity\User;
use App\Form\PageType;
use App\Form\TodoType;
use App\Manager\PageHistoryManager;
use App\Manager\PageManager;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

// TODO: Logique dans les managers

#[Route('/page', name: 'page_')]
class PageController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PageRepository         $pageRepository,
        private PageManager            $pageManager,
        private PageHistoryManager     $pageHistoryManager
    )
    {
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        // Récupération du parent via les query params (sinon null)
        $parent = $request->get('parent');
        $parent = $parent ? $this->pageRepository->find($parent) : null;

        /** @var  $user User */
        $user = $this->getUser();
        $parameters = new PageParameter();
        $page = new Page($user, $parameters, $parent, $this->pageManager->getMainParent($parent));

        $form = $this->createForm(PageType::class, $page);
        $form->add('submit', SubmitType::class, ['label' => 'Ajouter']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($page);
            $this->entityManager->flush();

            $this->addFlash("success", "La nouvelle page \"" . $page->getName() . "\" a bien été créée.");
            return $this->redirectToRoute('page_show', ['id' => $page->getId()]);
        }

        return $this->render('page/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/show/{id}', name: 'show', requirements: ['id' => "\d+"], methods: ['GET', 'POST'])]
    public function show(Page $page, Request $request): Response
    {
        $mainParent = $page->getMainParent() ?: $page;

        $todo = new Todo();
        $todoForm = $this->createForm(TodoType::class, $todo);
        $todoForm->add('submit', SubmitType::class, [
            'label' => 'Valider'
        ]);

        $todoForm->handleRequest($request);
        if ($todoForm->isSubmitted() && $todoForm->isValid()) {
            $todo->setPage($page);
            $this->entityManager->persist($todo);
            $this->entityManager->flush();

            $this->addFlash('success', 'La tâche "' . $todo->getValue() . '" a bien été ajoutée.');
            return $this->redirectToRoute('page_show', ['id' => $page->getId()]);
        }
        return $this->render('page/show.html.twig', [
                'page' => $page,
                'main_parent' => $mainParent,
                'todo_form' => $todoForm->createView()
            ]
        );
    }

    /**
     * @throws \Exception
     */
    #[Route('/update/{id}', name: 'update', requirements: ['id' => "\d+"], methods: ['GET', 'POST'])]
    public function update(Page $page, Request $request,): Response
    {
        $oldPage = clone $page;
        $form = $this->createForm(PageType::class, $page);
        $form->add('submit', SubmitType::class, ['label' => 'Enregistrer les modifications']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Création d'une version historique si il y a eu des modifications sur le name/body et mise à jour de la version
            if ($this->pageHistoryManager->shouldCreateHistory($page, $oldPage)) {
                try {
                    $page->updateVersion();
                    $pageHistory = $this->pageHistoryManager->create($oldPage, $page);
                    $this->entityManager->persist($pageHistory);
                } catch (\Exception $exception) {
                    throw new \Exception($exception);
                }
            }

            $this->entityManager->flush();

            $this->addFlash("success", "La page \"" . $page->getName() . "\" a bien été modifiée.");
            return $this->redirectToRoute('page_show', ['id' => $page->getId()]);
        }

        return $this->render('page/update.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/browse', name: 'browse', methods: ['GET'])]
    public function browse(Request $request): Response
    {
        $term = $request->get('term');
        $page = $this->pageManager->simpleSearch($term);
        return $this->render('page/browse.html.twig', ['pages' => $page]);
    }

    /**
     * Paramètres d'URL id => id de la page dont la version est demandée
     *
     * @param Page $page
     * @param int $version
     * @return Response
     */
    #[Route('/{id}/version/{version}', name: 'show_version', requirements: ['pageId' => "\d+", 'id' => "\d+"], methods: ['GET', 'POST'])]
    public function showVersion(Page $page, int $version): Response
    {
        $pageHistory = $this->pageHistoryManager->getPageHistoryByVersionNumber($page, $version);

        if (!$pageHistory) {
            throw new NotFoundHttpException();
        }

        return $this->render('page/show_version.html.twig', ['page' => $page, 'page_history' => $pageHistory]);
    }
}
