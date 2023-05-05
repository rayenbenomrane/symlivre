<?php

namespace App\Controller;

use DateTime;
use App\Entity\Book;
use App\Form\LivreType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;

class LivreController extends AbstractController
{
    #[Route('/admin/livre', name: 'app_livre')]
    public function listAll(bookRepository $rep, PaginatorInterface
    $paginator, Request $request): Response
    {
        $livres = $paginator->paginate(
            $rep->findAll(),
            $request->query->getInt('page', 1), // Numéro de la
            //page en cours, passé dans l'URL, 1 si aucune page
            10 // 3eme param 10,c’est le Nombre de résultats par page 10
        );
        return $this->render('livre/lister.html.twig', [
            'livres' => $livres,
        ]);
    }

    #[Route('/admin/livre/find/{id}', name: 'app_livre_detail')]
    public function chercher(int $id, BookRepository $bookRepository): Response
    {
        $livre =  $livre = $bookRepository->find($id);
        return $this->render('livre/detail.html.twig', [
            'livre' => $livre
        ]);
    }
    #[Route('/admin/livre/add', name: 'app_livre_add')]
    public function ajouter(request $request, ManagerRegistry $doctrine): Response
    {

        $livre = new Book();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livres = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($livre);
            $em->flush();
            return $this->redirectToRoute('app_livre');
        }
        return $this->render('livre/add.html.twig', ['form' => $form]);
    }
    #[Route('/admin/livre/update/{id}', name: 'app_livre_update')]
    public function update_price($id, ManagerRegistry $doctrine): Response
    {
        $rep = $doctrine->getRepository(Book::class);
        $livre = $rep->find($id);
        $livre->setPrix(150);
        $em = $doctrine->getManager();
        $em->flush();
        return $this->redirectToRoute('app_livre');
    }
    #[Route('/admin/livre/delete/{id}', name: 'app_livre_delete')]
    public function delete($id, ManagerRegistry $doctrine): Response
    {
        $rep = $doctrine->getRepository(Book::class);
        $livre = $rep->find($id);

        $em = $doctrine->getManager();
        $em->remove($livre);
        $em->flush();
        return $this->redirectToRoute('app_livre');
    }
}
