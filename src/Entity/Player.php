<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=64, name="gls_firstname")
     * @Assert\NotBlank
     * @Assert\Length(
     *  min = 3,
     *  max = 64,
     * )
     */
    private $firstname = 'Luca';

    /**
     * @ORM\Column(type="string", length=64, nullable=true, name="gls_lastname")
     * @Assert\Length(
     *  min = 3,
     *  max = 64,
     * )
     */
    private $lastname = 'Ciampi';

    /**
     * @ORM\Column(type="string", length=128, nullable=true, name="gls_email")
     * @Assert\Length(
     *  min = 3,
     *  max = 128,
     * )
     */
    private $email = 'luca.ciampi@hotmail.fr';

    /**
     * @ORM\Column(type="integer", nullable=true, name="gls_mirian")
     */
    private $mirian = 120;

    /**
     * @ORM\Column(type="datetime", name="gls_creation")
     */
    private $creation;

    /**
     * @ORM\Column(type="string", length=40, name="gls_identifier")
     * @Assert\Length(
     *  min = 40,
     *  max = 40,
     * )
     */
    private $identifier;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="gls_modification")
     */
    private $modification;

    /**
     * @ORM\OneToMany(targetEntity=Character::class, mappedBy="player", name="gls_characters")
     */
    private $characters;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
    }

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

    /**
     * @return Collection|Character[]
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters[] = $character;
            $character->setPlayer($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): self
    {
        if ($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if ($character->getPlayer() === $this) {
                $character->setPlayer(null);
            }
        }

        return $this;
    }
}
