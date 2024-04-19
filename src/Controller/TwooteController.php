<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\ReplyComment;
use App\Entity\Twoote;
use App\Form\CommentType;
use App\Form\ImageType;
use App\Form\ReplyCommentType;
use App\Form\TwooteType;
use App\Repository\CategoryRepository;
use App\Repository\TwooteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TwooteController extends AbstractController
{
    #[Route('/', name: 'app_twootes')]
    public function index(TwooteRepository $twooteRepository): Response
    {
        $twootes = $twooteRepository->findAll();
        return $this->render('twoote/index.html.twig', [
            'twootes' => $twootes
        ]);
    }

    #[Route ('/twoote/{id}', name: 'app_twoote')]
    public function show(Twoote $twoote):Response
    {
        if(!$this->getUser()){return $this->redirectToRoute("app_twootes");}

        $commentForm = $this->createForm(CommentType::class, new Comment());
        $replyForms = [];

        foreach ($twoote->getComments() as $commentItem) {
            $replyForm = $this->createForm(ReplyCommentType::class, new ReplyComment());
            $replyForms['replyForm_' . $commentItem->getId()] = $replyForm->createView();
        }

        $replyCommentForm = $this->createForm(ReplyCommentType::class, new ReplyComment());

        return $this->render('twoote/show.html.twig', [
            'twoote' => $twoote,
            'commentForm' => $commentForm->createView(),
            'replyForms' => $replyForms,
            'replyCommentForm' => $replyCommentForm->createView(),
        ]);
    }


    #[Route('/create', name: 'app_create')]
    public function create(Request $request, EntityManagerInterface $manager, CategoryRepository $categoryRepository):Response
    {

        if(!$this->getUser()){return $this->redirectToRoute("app_twootes");}
        $twoote = new Twoote();
        $form =  $this->createForm(TwooteType::class, $twoote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $twoote->setCreatedAt(new \DateTime());
            $twoote->setAuthor($this->getUser());
            $manager->persist($twoote);
            $manager->flush();

            return $this->redirectToRoute('app_twootes', ["id" => $twoote->getId()]);
        }

        return $this->render('twoote/create.html.twig',[
            'formulaire'=>$form->createView(),
            'retwoot' => false,
            'categorys' => $categoryRepository->findAll()
        ]);
    }

    #[Route('/retwoote/{id}', name: 'app_retwoote')]
    public function retwoote(Request $request, EntityManagerInterface $manager, Twoote $originalTwoote): Response
    {
        if(!$this->getUser()){return $this->redirectToRoute("app_twootes");}
        $retwoote = new Twoote();

        $form = $this->createForm(TwooteType::class, $retwoote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $retwoote->setRetwoot($originalTwoote);
            $retwoote->setCreatedAt(new \DateTime());
            $retwoote->setAuthor($this->getUser());
            $manager->persist($retwoote);
            $manager->flush();
            return $this->redirectToRoute('app_twootes');
        }

        return $this->render('twoote/create.html.twig', [
            'formulaire' => $form->createView(),
            'retwoot' => true
        ]);
    }


    #[Route('/twoote/delete/{id}', name:'app_delete')]
    public function delete(Twoote $twoote, EntityManagerInterface $manager):Response
    {
        if($this->getUser() === $twoote->getAuthor()) {
        $manager->remove($twoote);
        $manager->flush();
        return $this->redirectToRoute("app_twootes");
    }else {
            return $this->redirectToRoute("app_twootes");}
    }

    #[Route('/edit/{id}',name: 'app_edit')]
    public function edit(Request $request,EntityManagerInterface $manager,Twoote $twoote):Response
    {
        if($this->getUser() === $twoote->getAuthor()) {

            $formulaire = $this->createForm(TwooteType::class, $twoote);

            $formulaire->handleRequest($request);
            if ($formulaire->isSubmitted() && $formulaire->isValid()) {
                $manager->persist($twoote);
                $manager->flush();
                return $this->redirectToRoute("app_twoote", ["id" => $twoote->getId()]);
            }
        }else {
            return $this->redirectToRoute('app_twootes');
        }

        return $this->render("twoote/edit.html.twig",[
            "formulaire"=>$formulaire->createView()
        ]);
    }

    #[Route('/twoote/images/{id}', name:"twoote_image")]
    public function addImage(Request $request, EntityManagerInterface $manager, Twoote $twoote): Response
    {
        if ($this->getUser() === $twoote->getAuthor()) {
            $image = new Image();
            $formImage = $this->createForm(ImageType::class, $image);

            $formImage->handleRequest($request);
            if ($formImage->isSubmitted() && $formImage->isValid()) {
                $image->setTwoote($twoote);
                $manager->persist($image);
                $manager->flush();

                return $this->redirectToRoute("app_twoote", ["id" => $twoote->getId()]);
            }

            return $this->render("twoote/image.html.twig", [
                "twoote" => $twoote,
                'formImage' => $formImage->createView()
            ]);
        } else {
            return $this->redirectToRoute('app_twootes');
        }
    }

    #[Route('/my_twoots', name: 'app_my_twoots')]
    public function myTwoots(TwooteRepository $twooteRepository, Security $security): Response
    {
        $user = $security->getUser();

        $twootes = $twooteRepository->findBy(['author' => $user]);
        return $this->render('twoote/index.html.twig', [
            'twootes' => $twootes
        ]);
    }
}



