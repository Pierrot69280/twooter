<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\ReplyComment;
use App\Entity\Twoote;
use App\Form\ReplyCommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReplyCommentController extends AbstractController
{
    #[Route('/reply/comment/create/{id}', name: 'app_reply_comment_create')]
    public function create(Request $request, EntityManagerInterface $manager, Comment $comment): Response
    {

        if (!$this->getUser()) {

            return $this->redirectToRoute("app_twootes");
        }

        $twoote = $comment->getTwoote();

        $replyComment = new ReplyComment();
        $form = $this->createForm(ReplyCommentType::class, $replyComment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $replyComment->setTwoote($twoote);
            $replyComment->setComment($comment);
            $replyComment->setCreatedAt(new \DateTime());
            $replyComment->setAuthor($this->getUser());
            $manager->persist($replyComment);
            $manager->flush();

        }
        return $this->redirectToRoute("app_twoote", ["id" => $twoote->getId()]);
    }
}
