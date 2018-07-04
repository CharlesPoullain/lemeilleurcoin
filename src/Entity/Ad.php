<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdRepository")
 */
class Ad
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner le titre")
     * @Assert\Length(
     *     min=3,
     *     max=100,
     *     minMessage="2 caractères minimum",
     *     maxMessage="100 caractère maximum"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner la description")
     * @Assert\Length(
     *     min=3,
     *     max=100,
     *     minMessage="2 caractères minimum",
     *     maxMessage="100 caractère maximum"
     * )
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     *
     * @Assert\NotBlank(message="Veuillez renseigner la ville")
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @Assert\Regex("/^\d{5}$/", message="Code postal invalid")
     * @Assert\NotBlank(message="Veuillez renseigner le Code postal")
     * @ORM\Column(type="string", length=5)
     */
    private $zip;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner le prix")
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $dateCreated;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }
}
