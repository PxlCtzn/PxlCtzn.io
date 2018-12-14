<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    
    /**
     * @Route("/books/search", name="book_search")
     * 
     * @param string $candidate
     */
    public function search(Request $request)
    {
        $searchForm = $this->createFormBuilder()
        ->add('q', TextType::class)
        ->getForm();
        
        $searchForm->handleRequest($request);
        
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            list($candidate) = $searchForm->getData();
            var_dump($candidate);
            
            die();
        }
        
        return $this->render(
            'book/search.html.twig', 
            array(
                'search_form' => $searchForm->createView()
            )
        );
    }
}
