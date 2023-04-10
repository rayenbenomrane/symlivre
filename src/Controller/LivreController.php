<?php

namespace App\Controller;

use DateTime;
use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivreController extends AbstractController
{
    #[Route('/admin/livre', name: 'app_livre')]
    public function index(BookRepository $rep): Response
    {

        $livres = $rep->findAll();
        dd($livres);
    }
    #[Route('/admin/livre/find/{id}', name: 'app_livre_find')]
    public function chercher(BookRepository $livre): Response
    {

        dd($livre);
    }
    #[Route('/admin/livre/add', name: 'app_livre_add')]
    public function ajouter(ManagerRegistry $doctrine): Response
    {
        $date = new DateTime('2022-01-01');
        $livre = new Book();
        $livre->setLibelle("reseau");
        $livre->setResume("c est un reseau local");
        $livre->setImage("https://via.placeholder.com/300");
        $livre->setPrix(150);
        $livre->setEditeur("jean");
        $livre->setDateEdition($date);
        $em = $doctrine->getManager();
        $em->persist($livre);
        $em->flush();
        dd($livre);
    }
    #[Route('/admin/livre/update/{id}', name: 'app_livre_find')]
    public function update_price($id, ManagerRegistry $doctrine): Response
    {
        $rep = $doctrine->getRepository(Book::class);
        $livre = $rep->find($id);
        $livre->setPrix(150);
        $em = $doctrine->getManager();
        $em->flush();
        dd($livre);
    }
    #[Route('/admin/livre/delete/{id}', name: 'app_livre_find')]
    public function delete($id, ManagerRegistry $doctrine): Response
    {
        $rep = $doctrine->getRepository(Book::class);
        $livre = $rep->find($id);

        $em = $doctrine->getManager();
        $em->remove($livre);
        $em->flush();
        dd($livre);
    }
}
