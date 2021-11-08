<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id = 0;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $firstname = 'Luca';

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $lastname = 'Ciampi';

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $email = 'luca.ciampi@hotmail.fr';

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mirian = 120;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMirian(): ?int
    {
        return $this->mirian;
    }

    public function setMirian(?int $mirian): self
    {
        $this->mirian = $mirian;

        return $this;
    }
}
