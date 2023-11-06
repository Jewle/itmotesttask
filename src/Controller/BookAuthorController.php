<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

use App\Controller\Form\BookAuthorType;
use App\Entity\BookAuthor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BookAuthorController extends AbstractController
{

#[Route('/admin/create_author')]
    public function create_author(Request $request, EntityManagerInterface $entityManager){
        $bookAuthor = new BookAuthor();
        $form = $this->createForm(BookAuthorType::class, $bookAuthor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager->persist($data);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin');
        }
        return $this->render('admin/admin.author_edit.html.twig', [
            'form'=>$form,
        ]);


    }

    #[Route('/admin/aedit/{author_id}')]
    public function aedit(EntityManagerInterface $entityManager, $author_id,Request $request){
        $author = $entityManager->getRepository(BookAuthor::class)->find($author_id);
        $authorForm = $this->createForm(BookAuthorType::class, $author);
        $authorForm->handleRequest($request);
        if ($authorForm->isSubmitted() && $authorForm->isValid()) {
            $data = $authorForm->getData();
            $entityManager->persist($data);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin');
        }
        return $this->render('admin/admin.author_edit.html.twig', [
            'form'=>$authorForm
        ]);
    }
    #[Route('/admin/adelete/{author_id}')]
    public function adelete($author_id, EntityManagerInterface $entityManager){
        $author = $entityManager->getRepository(BookAuthor::class)->find($author_id);
        $entityManager->remove($author);
        $entityManager->flush();
        return $this->redirect('/admin');
    }
}