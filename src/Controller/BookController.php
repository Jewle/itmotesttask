<?php


namespace App\Controller;


use App\Controller\Form\BookType;
use App\Entity\Book;
use App\Entity\BookAuthor;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class BookController extends AbstractController
{
    #[Route('/admin/create_book')]
    public function createBook(Request $request,
                               EntityManagerInterface $entityManager,
                               FileUploader $fileUploader
){
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $bookImg = $form->get('bookImg')->getData();
            if ($bookImg) {
                $bookImgFileName = $fileUploader->upload($bookImg);
                $book->setBookImg($bookImgFileName);
            }
            $entityManager->persist($data);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin');
        }
        return $this->render('admin/admin.book_edit.html.twig', [
            'form'=>$form,
            'bookEdit'=>false
        ]);
    }
    #[Route('/admin/edit_book/{book_id}')]
    public function editBook($book_id,
                             FileUploader $fileUploader,
                             Request $request,
                             EntityManagerInterface $entityManager)
    {
        $book = $entityManager->getRepository(Book::class)->find($book_id);
        $attachedAuthors = $book->getAuthors();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        $bookAuthors = $entityManager->getRepository(BookAuthor::class)->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form>getData();
            $bookImg = $form->get('bookImg')->getData();
            if ($bookImg) {
                $bookImgFileName = $fileUploader->upload($bookImg);
                $book->setBookImg($bookImgFileName);
            }
            $entityManager->persist($data);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin');
        }
        return $this->render('admin/admin.book_edit.html.twig', [
            'form' => $form,
            'bookEdit' => true,
            'bookAuthors' => $bookAuthors,
            'attachedAuthors' => $attachedAuthors,
            'bookId' => $book->getId()
        ]);
    }
    #[Route('/admin/delete_book/{id}')]
    public function book_delete($id, EntityManagerInterface $entityManager){
        $book = $entityManager->getRepository(Book::class)->find($id);
        $entityManager->remove($book);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin');
    }
}