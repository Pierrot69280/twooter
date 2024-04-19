<?php

namespace App\Controller;


use App\Entity\Twoote;
use App\Entity\Comment;
use App\Entity\Like;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LikeController extends AbstractController
{
    #[Route('/like/twoote/{id}', name: 'app_like')]
    #[Route('/like/comment/{id}', name: 'comment_like')]

    public function like(Request $request, EntityManagerInterface $manager, LikeRepository $likeRepository, Twoote $twoote = null, Comment $comment = null): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json("no user connected", 400);
        }

        if ($twoote !== null) {
            $entity = $twoote;
        } elseif ($comment !== null) {
            $entity = $comment;
        } else {
            return $this->json("No twoote or comment trouvé", 400);
        }

        if ($entity->isLikedBy($user)) {
            $like = $likeRepository->findOneBy([
                'author' => $user,
                'twoote' => $twoote,
                'comment' => $comment,
            ]);
            $manager->remove($like);
            $isLiked = false;
        } else {
            $like = new Like();
            if ($twoote !== null) {
                $like->setTwoote($twoote);
            } elseif ($comment !== null) {
                $like->setComment($comment);
            }
            $like->setAuthor($user);
            $manager->persist($like);
            $isLiked = true;
        }

        $manager->flush();

        $data = [
            'liked' => $isLiked,
            'count' => $likeRepository->count(['twoote' => $twoote, 'comment' => $comment])
        ];
        return $this->json($data, 200);
    }
}