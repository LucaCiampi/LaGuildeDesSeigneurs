<?php

namespace App\Service;

use App\Entity\Character;

interface CharacterServiceInterface
{
    /**
     * Creates the character
     */
    public function create(string $data);

    /**
     * Gets all the characters
     */
    public function getAll();

    /**
     * Modifies the character
     */
    public function modify(Character $character, string $data);

    /**
     * Deletes the character
     */
    public function delete(Character $character);

    /**
     * Gets images randomly
     */
    public function getImages(int $number, ?string $kind = null);

    /**
     * Checks if the entity has been well filled
     */
    public function isEntityFilled(Character $character);

    /**
     * Submits the data to hydrate the object
     */
    public function submit(Character $character, $formname, $data);

    /**
     * Serializes the object(s)
     */
    public function serializeJson($data);
}
