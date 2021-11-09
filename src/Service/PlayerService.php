<?php

namespace App\Service;

use DateTime;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;
use LogicException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use App\Form\PlayerType;

class PlayerService implements PlayerServiceInterface
{
    private $playerRepository;
    private $em;
    private $formFactory;

    public function __construct(
        PlayerRepository $playerRepository,
        EntityManagerInterface $em,
        FormFactoryInterface $formFactory
        )
    {
        $this->playerRepository = $playerRepository;
        $this->em = $em;
        $this->formFactory = $formFactory;
    }

    public function create(string $data)
    {
        $player = new Player();
        $player
            ->setIdentifier(hash('sha1', uniqid()))
            ->setCreation(new DateTime())
            ->setModification(new DateTime())
        ;
        $this->submit($player, PlayerType::class, $data);
        $this->isEntityFilled($player);

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function modify(Player $player, string $data): Player {
        $this->submit($player, PlayerType::class, $data);
        $this->isEntityFilled($player);
        
        $player
            ->setModification(new DateTime())
        ;

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function isEntityFilled(Player $player)
    {
        if (null === $player->getFirstname() ||
            null === $player->getLastname() ||
            null === $player->getEmail() ||
            null === $player->getMirian() ||
            null === $player->getCreation() ||
            null === $player->getModification()) {
            throw new UnprocessableEntityHttpException('Missing data for Entity -> ' . json_encode($player->toArray()));
        }
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
    public function delete(Player $player): bool {
        $this->em->remove($player);
        $this->em->flush();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function submit(Player $player, $formName, $data)
    {
        $dataArray = is_array($data) ? $data : json_decode($data, true);

        //Bad array
        if (null !== $data && !is_array($dataArray)) {
            throw new UnprocessableEntityHttpException('Submitted data is not an array -> ' . $data);
        }

        //Submits form
        $form = $this->formFactory->create($formName, $player, ['csrf_protection' => false]);
        $form->submit($dataArray, false);//With false, only submitted fields are validated

        //Gets errors
        $errors = $form->getErrors();
        foreach ($errors as $error) {
            throw new LogicException('Error ' . get_class($error->getCause()) . ' --> ' . $error->getMessageTemplate() . ' ' . json_encode($error->getMessageParameters()));
        }
    }
}