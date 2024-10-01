<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    public $authors = array(
        array('id' => 1, 'picture' => 'public/pictures/victor.jpg','username' => 'Victor Hugo', 'email' =>
        'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => 'public/pictures/william.jpg','username' => ' William Shakespeare', 'email' =>
        ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => 'public/pictures/taha.jpg','username' => 'Taha Hussein', 'email' =>
        'taha.hussein@gmail.com', 'nb_books' => 300),
        );
    #[Route('/show', name: 'app_author')]
    public function showAuthor(): Response
    {
        return $this -> render('author/list.html.twig',[
                "data"=>$this->authors
            ]);
    }

    
    #[Route('/authorDetails/{identity}', name:'author_details')]
    public function authorDetails($identity){

        //$newAuthor= null;

        // foreach($this->authors as $a){
        //     if($a['id']== $identity){
        //         $newAuthor = $a;
        //     }

        // }

       // return $this ->render("author/showAuthor.html.twig", ["author"=> $newAuthor]);
        return $this ->render("author/showAuthor.html.twig", ["id"=> $identity]);

    }

    //function to list authors in a table
    #[Route('/listAuthors', name:"list_author")]
    public function listAuthorsFromDB( AuthorRepository $repo)
    {
        $authors = $repo->findAll();
        return $this->render("author/authordb.html.twig", ["list"=>$authors]);
        // on peut faire : ["list"=> $repo->findAll() direct sans utiliser le ligne authors ]

    }

// function to add an author manually
    #[Route('addAuth')]
    public function addAuthors(ManagerRegistry $doctrine){
        $em = $doctrine->getManager();
        $author = new Author();

        $author->setUsername("Eline");
        $author->setEmail("eline@gmail.com");


        $em->persist($author);
        $em->flush(); //pour l'execution

       // return $this->render("author/add.html.twig", []);
        return $this->redirectToRoute("list_author"); // on l'utilise pour directement afficher l'author dans le tableau 
    }

    
    
}

