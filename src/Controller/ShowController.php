<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    #[Route('/show', name: 'app_show')]
    public function index(EntityManagerInterface $entityManager){
        $books  = $entityManager->getRepository(Book::class)->findAll();
        return $this->render('show/index.html.twig', [
            'books'=>$books,
            'files_dir'=>$this->getParameter('files')
        ]);
    }
}
