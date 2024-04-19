<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Twoote;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ImageController extends AbstractController
{
    #[Route('/image/add/twoote/{id}', name: 'add_twoote_image')]
    public function index($id, Request $request, EntityManagerInterface $manager): Response
    {
        $route = $request->attributes->get("_route");

        switch ($route){

            case 'add_twoote_image':
                $entity = Twoote::class;
                $setter = "setTwoote";
                $redirectRoute = "twoote_image";
                $routeParam= ["id"=>$id];
                break;
        }


        $toBeAddedAnImage = $manager->getRepository($entity)->find($id);


        //en fonction de la route, récuperer la bonne entité

        $image = new Image();
        $formImage = $this->createForm(ImageType::class, $image);
        $formImage->handleRequest($request);
        if($formImage->isSubmitted() && $formImage->isValid())
        {

            $image->$setter($toBeAddedAnImage);
            $manager->persist($image);
            $manager->flush();

        }
        return $this->redirectToRoute($redirectRoute, $routeParam);
    }
}
