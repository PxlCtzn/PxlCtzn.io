<?php
namespace App\Utils\BookWorms;

abstract class BookWorm
{
    final public function sanitize($candidate): string
    {
        return preg_replace('/[^0-9]/', '', $candidate);
    }
    
    /**
     * Returns true if the given ISBN is valid 
     * (but that does not mean it exist).
     * 
     * @param   mixed  $isbnCandidate The ISBN we want to validate
     * 
     * @return  bool    True if the isbn is valid, else false
     */
    final public static function validateISBN($isbnCandidate): bool
    {
        $isbnCandidate = self::cleanCandidate($isbnCandidate);
        
        $isValid = length($isbnCandidate) <= 10;
        
        return $isValid;
    }
    

}