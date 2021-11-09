<?php

namespace App\Service;

use DateTime;
use App\Entity\Character;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;

class CharacterService implements CharacterServiceInterface
{
    private $characterRepository;
    private $em;

    public function __construct(
        CharacterRepository $characterRepository,
        EntityManagerInterface $em
        )
    {
        $this->characterRepository = $characterRepository;
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
            ->setIdentifier(hash('sha1', uniqid()))
        ;

        $this->em->persist($character);
        $this->em->flush();

        return $character;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(): array
    {
        $charactersFinal = array();
        $characters = $this->characterRepository->findAll();

        foreach ($characters as $character) {
            $charactersFinal[] = $character->toArray();
        }

        return $charactersFinal;
    }

    /**
     * {@inheritdoc}
     */
    public function modify(Character $character): Character {
        $character
            ->setKind('Dame')
            ->setName('EldaloteModified')
            ->setSurname('Fleur terrible')
            ->setCaste('Elfe')
            ->setKnowledge('Arts')
            ->setIntelligence(130)
            ->setLife(14)
            ->setImage('/images/eldalote.jpg')
            ->setModification(new DateTime())
        ;

        $this->em->persist($character);
        $this->em->flush();

        return $character;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Character $character): bool {
        $this->em->remove($character);
        $this->em->flush();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getImages(int $number, ?string $kind = null)
    {
        $folder = __DIR__ . '/../../public/images/';

        $finder = new Finder();
        $finder
            ->files()
            ->in($folder)
            ->notPath('/cartes/')
            ->sortByName()
        ;

        if (null !== $kind) {
            $finder->path('/' . $kind . '/');
        }

        $images = array();
        foreach ($finder as $file) {
            $images[] = '/images/' . str_replace('\\', '', $file->getRelativePathname());
        }
        shuffle($images);

        return array_slice($images, 0, $number, true);
    }
}