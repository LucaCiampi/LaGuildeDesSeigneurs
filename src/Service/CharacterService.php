<?php

namespace App\Service;

use DateTime;
use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;

class CharacterService implements CharacterServiceInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function create(): Character {
        $character = new Character();
        $character
            ->setKind('Dame')
            ->setName('Eldalote')
            ->setSurname('Fleur eflique')
            ->setCaste('Elfe')
            ->setKnowledge('Arts')
            ->setIntelligence(120)
            ->setLife(12)
            ->setImage('/images/eldalote.jpg')
            ->setCreation(new DateTime())
        ;
        
        $this->em->persist($character);
        $this->em->flush();

        return $character;
    }
}