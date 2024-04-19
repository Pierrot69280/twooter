<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Twoote;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    #[Route('/comment/create/{id}', name: 'app_comment_create')]
    public function create(Request $request, EntityManagerInterface $manager, Twoote $twoote): Response
    {
        if(!$this->getUser()){return $this->redirectToRoute("app_twootes");}

        if (!$this->getUser()) {
            return $this->redirectToRoute("app_twootes");
        }

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setTwoote($twoote);
            $comment->setCreatedAt(new \DateTime());
            $comment->setAuthor($this->getUser());
            $manager->persist($comment);
            $manager->flush();

        }
        return $this->redirectToRoute("app_twoote", ["id" => $twoote->getId()]);
    }

    #[Route('/comment/delete/{id}', name: 'app_comment_delete')]
    public function delete(Comment $comment, EntityManagerInterface $manager): Response
    {
        if($this->getUser() === $comment->getAuthor()) {
        $twoote = $comment->getTwoote();
        $manager->remove($comment);
        $manager->flush();

        return $this->redirectToRoute("app_twoote", ["id" => $twoote->getId()]);

    }else{
            return $this->redirectToRoute("app_twootes");
        }
    }

}
