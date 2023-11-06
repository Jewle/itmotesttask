<?php


namespace App\Controller\Form;
use App\Entity\Book;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bookTitle', TextType::class)
            ->add('bookPubYear', NumberType::class)
            ->add('bookPages', NumberType::class)
            ->add('bookIsbn', TextType::class)
            ->add('bookImg', FileType::class, array(
                'required'=>false,
                'multiple'    => false,
                'data_class'=>null,
                'attr' => array(

                    'accept' => 'image/*',
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }

}