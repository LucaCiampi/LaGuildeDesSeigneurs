<?php
namespace App\Service;

use App\Entity\Character;

interface CharacterServiceInterface
{
    /**
     * Creates the character
     */
    public function create();
    
    /**
     * Gets all the characters
     */
    public function getAll();
    
    /**
     * Gets all the characters
     */
    public function modify(Character $character);
}