<?php
namespace App\Utils\BookWorms\Web;
use Goutte\Client;

class AmazonCrawler
{
    private $client;
    private $crawler;
    
    public function __construct()
    {
        $this->client = new Client();
    }
    
    public function findByISBN($isbn): array
    {
        $query = "https://www.amazon.com/gp/search/ref=sr_adv_b/?search-alias=stripbooks&unfiltered=1&field-keywords=&field-author=&field-title=&field-isbn=".$isbn."&field-publisher=&node=&field-p_n_condition-type=&p_n_feature_browse-bin=&field-age_range=&field-language=&field-dateop=During&field-datemod=&field-dateyear=&sort=relevanceexprank&Adv-Srch-Books-Submit.x=18&Adv-Srch-Books-Submit.y=5";
        $resultPage = $this->client->request('GET', $query);

        $firstResultLink = $resultPage->filter("#result_0 a");
        echo("<pre>");
        var_dump($firstResultLink);
        echo("</pre>");
        die();
        
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

