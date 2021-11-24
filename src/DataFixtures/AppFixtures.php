<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Service\CharacterServiceInterface;
use App\Service\PlayerServiceInterface;
use DateTime;

class AppFixtures extends Fixture
{
    private $characterService;
    private $playerService;

    public function __construct(CharacterServiceInterface $characterService, PlayerServiceInterface $playerService)
    {
        $this->characterService = $characterService;
        $this->playerService = $playerService;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 10; $i++) {
            $character = new Character();
            $character
                ->setKind('Dame')
                ->setName('Eldalote' . $i)
                ->setSurname('Fleur elfique')
                ->setCaste('Elfe')
                ->setKnowledge('Arts')
                ->setIntelligence(120)
                ->setLife(12)
                ->setImage('/images/eldalote')
                ->setIdentifier(hash('sha1', uniqid()))
                ->setCreation(new DateTime())
            ;
            $manager->persist($character);

            $player = new Player();
            $player
                ->setFirstname('Luca' . $i)
                ->setLastname('Ciampi')
                ->setEmail('luca.ciampi@mail.com')
                ->setMirian(267)
                ->setIdentifier(hash('sha1', uniqid()))
                ->setCreation(new DateTime())
            ;
            $manager->persist($player);
        }
        $manager->flush();
    }
}
