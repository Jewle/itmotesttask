<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\PersistentCollection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\BookAuthor;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[UniqueEntity(bookIsbn)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $book_title = null;

    #[ORM\Column]
    #[Assert\Type(\NumberType::class)]
    private ?int $book_pub_year = null;

    #[ORM\Column]
    private ?int $book_pages = null;

    #[ORM\Column(length: 10, unique:true)]
    private ?string $book_isbn = null;

    #[ORM\Column(length: 255)]
    private  $book_img = null;


    #[ORM\ManyToMany(targetEntity: BookAuthor::class, inversedBy: 'books')]
    private $authors;
    public function __construct()
    {
        $this->authors;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookTitle(): ?string
    {
        return $this->book_title;
    }

    public function setBookTitle(string $book_title): static
    {
        $this->book_title = $book_title;

        return $this;
    }

    public function getBookPubYear(): ?int
    {
        return $this->book_pub_year;
    }

    public function setBookPubYear(int $book_pub_year): static
    {
        $this->book_pub_year = $book_pub_year;

        return $this;
    }

    public function getBookPages(): ?int
    {
        return $this->book_pages;
    }

    public function setBookPages(int $book_pages): static
    {
        $this->book_pages = $book_pages;

        return $this;
    }

    public function getBookIsbn(): ?string
    {
        return $this->book_isbn;
    }

    public function setBookIsbn(string $book_isbn): static
    {
        $this->book_isbn = $book_isbn;

        return $this;
    }
    public function getBookImg(): ?string
    {
        return $this->book_img;
    }

    public function setBookImg(string $book_img): static
    {
        $this->book_img = $book_img;

        return $this;
    }


    public function getAuthors()
    {
        return $this->authors;
    }
    public function getAuthorsIds(){
        $ids  = [];
        foreach ($this->authors as $author){
            $ids[] = $author->getId();
        }
        return $ids;
    }


    public function addAuthor(BookAuthor $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors[] = $author;
        }

        return $this;
    }

    public function removeAuthor(BookAuthor $author): self
    {
        $this->authors->removeElement($author);

        return $this;
    }
}
