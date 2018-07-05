<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Veuillez renseigner un username")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner un email")
     */
    private $email;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRegistered;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner un mot de passe")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ad", mappedBy="maker")
     */
    private $ads;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Ad", inversedBy="users")
     */
    private $bookmark;


    public function __construct()
    {
        $this->ads = new ArrayCollection();
        $this->bookmark = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getDateRegistered(): ?\DateTimeInterface
    {
        return $this->dateRegistered;
    }

    public function setDateRegistered(\DateTimeInterface $dateRegistered): self
    {
        $this->dateRegistered = $dateRegistered;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    //Implementations
    public function getSalt()
    {
       return null;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return Collection|Ad[]
     */
    public function getAds(): Collection
    {
        return $this->ads;
    }

    public function addAd(Ad $ad): self
    {
        if (!$this->ads->contains($ad)) {
            $this->ads[] = $ad;
            $ad->setMaker($this);
        }

        return $this;
    }

    public function removeAd(Ad $ad): self
    {
        if ($this->ads->contains($ad)) {
            $this->ads->removeElement($ad);
            // set the owning side to null (unless already changed)
            if ($ad->getMaker() === $this) {
                $ad->setMaker(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ad[]
     */
    public function getBookmark(): Collection
    {
        return $this->bookmark;
    }

    public function addBookmark(Ad $bookmark): self
    {
        if (!$this->bookmark->contains($bookmark)) {
            $this->bookmark[] = $bookmark;
        }

        return $this;
    }

    public function removeBookmark(Ad $bookmark): self
    {
        if ($this->bookmark->contains($bookmark)) {
            $this->bookmark->removeElement($bookmark);
        }

        return $this;
    }


}
