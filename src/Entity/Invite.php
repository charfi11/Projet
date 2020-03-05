<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InviteRepository")
 */
class Invite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="invites")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Groupe", inversedBy="invites")
     */
    private $groupe;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->groupe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupe(): Collection
    {
        return $this->groupe;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupe->contains($groupe)) {
            $this->groupe[] = $groupe;
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupe->contains($groupe)) {
            $this->groupe->removeElement($groupe);
        }

        return $this;
    }
}
