<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="players")
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
     * @Assert\NotBlank
     * @Assert\Length(
     *  min = 3,
     *  max = 64,
     * )
     */
    private $firstname = 'Luca';

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Assert\Length(
     *  min = 3,
     *  max = 64,
     * )
     */
    private $lastname = 'Ciampi';

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     * @Assert\Length(
     *  min = 3,
     *  max = 128,
     * )
     */
    private $email = 'luca.ciampi@hotmail.fr';

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mirian = 120;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creation;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\Length(
     *  min = 40,
     *  max = 40,
     * )
     */
    private $identifier;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modification;

    /**
     * Converts the entity in an array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

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

    public function getCreation(): ?\DateTimeInterface
    {
        return $this->creation;
    }

    public function setCreation(\DateTimeInterface $creation): self
    {
        $this->creation = $creation;

        return $this;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getModification(): ?\DateTimeInterface
    {
        return $this->modification;
    }

    public function setModification(?\DateTimeInterface $modification): self
    {
        $this->modification = $modification;

        return $this;
    }
}
