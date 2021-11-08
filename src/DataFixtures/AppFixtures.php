<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Service\CharacterServiceInterface;

class AppFixtures extends Fixture
{
    private $characterService;

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 10; $i++) { 
            $this->characterService->create();
        }
    }
}
