<?php

namespace App\Controller;

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
    
    #[Route('/authorDetails/{identity}', name:'authordetails_app')]
    public function authorDetails($identity){
        $newAuthor= null;

        foreach($this->authors as $a){
            if($a['id']== $identity){
                $newAuthor = $a;
            }

        }

        return $this ->render("author/showAuthor.html.twig", ["author"=> $newAuthor]);
    }
    
}

