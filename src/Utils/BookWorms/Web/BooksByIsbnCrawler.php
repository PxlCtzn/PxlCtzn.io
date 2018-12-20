<?php
namespace App\Utils\BookWorms\Web;

use Goutte\Client;

class BooksByIsbnCrawler
{
    private $client;
    private $crawler;
    
    public function __construct()
    {
        $this->client = new Client();
    }
    
    public function findByISBN($isbn): array
    {
        $this->crawler = $this->client->request(
            'GET', 
            'https://www.books-by-isbn.com/cgi-bin/isbn-lookup.pl?isbn='.$isbn
        );
        
        return array(
            'name'      => $this->getTitle(),       // Title
            'author'    => $this->getAuthor(),      // Author
            'image'     => $this->getCoverImage(),  // Cover Image
            'publisher' => $this->getPublisher(),   // Publisher
            'isbn'      => $this->getISBN(),        //ISBN
        );
    }
    
    /**
     * Returns Cover image URL
     */
    protected function getCoverImage()
    {
        return $this->crawler->filter('img.cover')->attr('src');
    }
    
    /**
     * Returns Book title
     */
    protected function getTitle()
    {
        return $this->crawler->filter('h1.title')->text();
    }
    
    protected function getAuthor()
    {
        return $this->crawler->filter('span.auts:last-child')->text();
    }
    
    protected function getPublisher()
    {
        return $this->crawler->filter('p.pubinf > a')->text();
    }
    
    protected function getISBN()
    {
        return $this->crawler->filter('p.i10')->text();
    }
    
    protected function getEAN()
    {
        return $this->crawler->filter('p.i13')->text();
    }
}

