<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType as FormAuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('addAuth', name:"add_author")]
    public function addAuthors(ManagerRegistry $doctrine){
        $em = $doctrine->getManager();
        $author = new Author();

        $author->setUsername("Julia");
        $author->setEmail("julia@gmail.com");


        $em->persist($author);
        $em->flush(); //pour l'execution

       // return $this->render("author/add.html.twig", []);
        return $this->redirectToRoute("list_author"); // on l'utilise pour directement afficher l'author dans le tableau 
    }

    // we use symfony console make:form AuthorType
    #[Route('/add', name:'author_add_form')]
    public function add(Request $request, ManagerRegistry $doctrine) {
        $author=new Author();
        $form = $this-> createForm(FormAuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            if($author->getUsername()!="" && $author->getEmail()!=""){
                $em->persist($author);
                $em->flush();
                $this->addFlash('sucess', 'Author added successfully');
                return $this->redirectToRoute("list_author");
            }

    }  
    return $this->renderForm("author/add.html.twig", ["formulaire" => $form]);

}

}