<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Manager\TodoManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/todo', name: 'todo_')]
class TodoController extends AbstractController
{
    private $serializer;

    public function __construct(private EntityManagerInterface $entityManager, private TodoManager $todoManager)
    {
        $normalizer = new ObjectNormalizer();
        $encoder = new JsonEncode();
        $this->serializer = new Serializer([$normalizer], [$encoder]);
    }

    #[Route('/remove/{id}', name: 'remove', requirements: ['id' => "\d+"], methods: ['POST'])]
    public function remove(Todo $todo, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('delete-todo', $request->request->get('_csrf_token'))) {
            throw new InvalidCsrfTokenException();
        }

        $this->entityManager->remove($todo);
        $this->entityManager->flush();

        $this->addFlash('success', 'La tâche "' . $todo->getValue() . '" a bien été supprimée.');

        return $this->redirectToRoute('page_show', ['id' => $todo->getPage()->getId()]);
    }

    #[Route('/check/{id}', name: 'api_check', requirements: ['id' => "\d+"], methods: ['POST'])]
    public function check(Todo $todo, Request $request): Response
    {
        $json = json_decode($request->getContent(), false);

        if (!$this->isCsrfTokenValid('check-todo', $json->_csrf_token)) {
            return new JsonResponse(json_encode(['message' => 'Jeton CSRF invalide']), 401, [], true);
        }

        try {
            $todo = $this->todoManager->updateIsDone($todo);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(json_encode(['message' => $exception->getMessage()]), 500, [], true);
        }

        // Ne contient pas la page
        return new JsonResponse($this->serializer->serialize($todo, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['page']]), 200, [], true);
    }
}
