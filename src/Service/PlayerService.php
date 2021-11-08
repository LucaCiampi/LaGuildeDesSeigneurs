<?php

namespace App\Service;

use DateTime;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;

class PlayerService implements PlayerServiceInterface
{
    private $playerRepository;
    private $em;

    public function __construct(
        PlayerRepository $playerRepository,
        EntityManagerInterface $em
        )
    {
        $this->playerRepository = $playerRepository;
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function create(): Player {
        $player = new Player();
        $player
            ->setFirstname('Théo')
            ->setLastname('Labotte')
            ->setEmail('theo.labotte@hotmail.fr')
            ->setMirian(222)
            ->setCreation(new DateTime())
            ->setIdentifier(hash('sha1', uniqid()))
        ;

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(): array
    {
        $playersFinal = array();
        $players = $this->playerRepository->findAll();

        foreach ($players as $player) {
            $playersFinal[] = $player->toArray();
        }

        return $playersFinal;
    }

    /**
     * {@inheritdoc}
     */
    public function modify(Player $player): Player {
        $player
            ->setFirstname('Jacques')
            ->setLastname('Lachaud')
            ->setEmail('jacques.lachaud@hotmail.fr')
            ->setMirian(222)
            ->setModification(new DateTime())
        ;

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Player $player): bool {
        $this->em->remove($player);
        $this->em->flush();

        return true;
    }
}