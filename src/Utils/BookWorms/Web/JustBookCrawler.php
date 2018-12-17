<?php
namespace App\Utils\BookWorms\Web;

use Goutte\Client;

class JustBookCrawler 
{
    private $client;
    private $crawler;
    
    public function __construct()
    {
        $this->client = new Client();
    }
    
    public function findByISBN($isbn): array
    {
        $this->crawler = $this->client->request('GET', 'https://www.justbooks.fr/search/?isbn='.$isbn.'&mode=isbn&st=sr&ac=qr');
        
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
        return $this->crawler->filter('img[itemprop~="image"]')->attr('src');
    }
    
    /**
     * Returns Book title
     */
    protected function getTitle()
    {
        return $this->crawler->filter('span[itemprop="name"]')->text();
    }
    
    protected function getAuthor()
    {
        return $this->crawler->filter('span[itemprop="author"]')->text();
    }
    
    protected function getPublisher()
    {
        return $this->crawler->filter('span[itemprop="publisher"]');
    }
    
    protected function getISBN()
    {
        return $this->crawler->filter('[itemprop~="isbn"]')->text();
    }
}

