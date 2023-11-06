<?php


namespace App\Controller;


use App\Entity\Book;
use App\Entity\BookAuthor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    //Ajax
    #[Route('/admin/attach_authors', methods:['POST'])]
    public function attachAuthors(Request $request, EntityManagerInterface $entityManager){
        $data = json_decode($request->getContent());
        if ($data->bookId){
            $currentBook = $entityManager->getRepository(Book::class)->findOneById($data->bookId);
            $attachableAuthors = $entityManager->getRepository(BookAuthor::class)
                ->findBy(['id'=>$data->authors]);
            foreach ($attachableAuthors as $attachableAuthor){
                $currentBook->addAuthor($attachableAuthor);
            }
            $entityManager->persist($currentBook);
            $entityManager->flush();
            return new Response(json_encode($attachableAuthors));
        }

        return new Response(json_encode('Ошибка'));
    }

    #[Route('/ajax/check_author', methods:['POST'])]
    public function check_author(Request $request, EntityManagerInterface $entityManager){
        $response = new Response();

        $data = json_decode($request->getContent())->nameValues;
        $firstName = $data[0];
        $lastName = $data[1];
        $middleName = $data[2];

        $checking_author = $entityManager->getRepository(BookAuthor::class)->findOneBy([
            'firstName' => $firstName,
            'lastName'=> $lastName,
            'middleName'=>$middleName
        ]);
        if ($checking_author){
            $response->setStatusCode(Response::HTTP_CONFLICT);
            $response->sendContent('Такой автор уже существует');
            return $response;
        }

        return new Response('ok');
    }

}