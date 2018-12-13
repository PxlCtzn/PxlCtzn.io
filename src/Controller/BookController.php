<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/books", name="books")
     */
    public function index()
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    
    
    /**
     * @Route("/books/add", name="book_add")
     */
    public function add()
    {
        return $this->render('book/search.html.twig', array());
    }
    
    /**
     * 
     * @param string $candidate
     */
    public function search(string $candidate)
    {
        return $this->render('book/search.html.twig', array());
    }
    
}
