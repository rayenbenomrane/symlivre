<?php

namespace App\Controller;

use doctrine;
use App\Entity\Categories;
use App\Form\CategorieType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{


    #[Route('/admin/categorie/create', name: 'admin_categorie_create')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $cat = new Categories();
        $form = $this->createForm(CategorieType::class, $cat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cat = $form->getData();
            $em = $doctrine->getmanager();
            $em->persist($cat);
            $em->flush();
            return new response('l object categorie est ajoute avec succes ');
        }
        return $this->render('Categorie/create.html.twig', ['form' => $form]);
    }
}
