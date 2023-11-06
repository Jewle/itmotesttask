<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\BookAuthor;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
//    private $entityManager;
//    public function __construct($entityManager){
//        $this->entityManager = $entityManager;
//    }

    #[Route('/admin', name: 'app_admin')]
    public function index(EntityManagerInterface $entityManager){
        $authors = $entityManager->getRepository(BookAuthor::class)->findAll();
        $books = $entityManager->getRepository(Book::class)->findAll();
        return $this->render('admin/admin.html.twig', [
            'authors' =>$authors,
            'books'=>$books,
        ]);
    }
}

