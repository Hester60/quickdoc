<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('/edit-password', name: 'edit_password')]
    public function editPassword(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(UserPasswordType::class, $this->getUser());
        $form->add('submit', SubmitType::class, [
            'label' => 'Modifier mon mot de passe'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->getUser();
            $user->setPassword($hasher->hashPassword($user, $form->getData()->getPassword()));
            $entityManager->flush();
            $this->addFlash('success', "Vous avez modifié votre mot de passe.");
            return $this->redirectToRoute('page_browse');
        }
        return $this->render('user/edit_password.html.twig', ['form' => $form->createView()]);
    }
}
