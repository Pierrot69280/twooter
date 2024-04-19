<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\TwooteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/follow/{id}', name: 'app_follow')]
    public function follow(Security $security, User $user, EntityManagerInterface $manager): Response
    {
        if (!$this->getUser()){return $this->redirectToRoute('app_twootes');}

        $me = $security->getUser();
        $me->addFollow($user);

        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('app_profil', ["id"=>$user->getId()]);
    }

    #[Route('/profil/{id}/follows', name: 'app_follow_user')]
    public function followUser(Security $security, User $user): Response{



        return $this->render('user/follows.html.twig', [
            'follows' => $user->getFollow(),
            'user' => $user
        ]);
    }

    #[Route('/profil/{id}/followers', name: 'app_followers_user')]
    public function followersUser(Security $security, User $user): Response
    {
        return $this->render('user/followers.html.twig', [
            'followers' => $user->getFollowers(),
            'user' => $user
        ]);
    }

    #[Route('/profil/edit', name: 'edit_profil')]
    public function edit(Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $form =  $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_profil', ["id"=>$user->getId()]);

        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profil/{id}', name: 'app_profil')]
    public function profil (User $user): Response
    {

        if (!$this->getUser()){return $this->redirectToRoute('app_twootes');}

        return $this->render('user/index.html.twig', [
            'user' => $user,
            'isFollowed' => $user->isFollowedBy($this->getUser())
        ]);
    }

    #[Route('/unfollow/{id}', name: 'app_unfollow')]
    public function unfollow(Security $security, User $user, EntityManagerInterface $manager): Response
    {
        $me = $security->getUser();
        $me->removeFollow($user);

        $manager->persist($me);
        $manager->flush();

        return $this->redirectToRoute('app_profil', ['id' => $user->getId()]);
    }
}
