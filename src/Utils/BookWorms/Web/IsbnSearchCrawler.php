<?php
namespace App\Utils\BookWorms\Web;

use Goutte\Client;

class IsbnSearchCrawler
{
    private $client;
    private $crawler;
    
    public function __construct()
    {
        $this->client = new Client();
    }
    
    public function findByISBN($isbn): array
    {
        $this->crawler = $this->client->request('GET', 'https://isbnsearch.org/isbn/'.$isbn);
        
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
        return $this->crawler->filter('div#book > div.image > img')->attr('src');
    }
    
    /**
     * Returns Book title
     */
    protected function getTitle()
    {
        return $this->crawler->filter('div#book > div.bookinfo > h1')->text();
    }
    
    protected function getAuthor()
    {
        throw new \RuntimeException("Can not fetch 'Author' from this source.");
    }
    
    protected function getPublisher()
    {
        throw new \RuntimeException("Can not fetch 'Publisher' from this source.");
    }
    
    protected function getISBN()
    {
        return $this->crawler->filter('div#book > div.bookinfo > p > a')->text();
    }
}

