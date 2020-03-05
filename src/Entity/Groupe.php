<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupeRepository")
 */
class Groupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="groupe")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evenement", mappedBy="groupe", cascade={"remove"})
     */
    private $event;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Invite", mappedBy="groupe")
     */
    private $invites;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="grps")
     */
    private $users;

    public function __construct()
    {
        $this->event = new ArrayCollection();
        $this->invites = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(Evenement $event): self
    {
        if (!$this->event->contains($event)) {
            $this->event[] = $event;
            $event->setGroupe($this);
        }

        return $this;
    }

    public function removeEvent(Evenement $event): self
    {
        if ($this->event->contains($event)) {
            $this->event->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getGroupe() === $this) {
                $event->setGroupe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Invite[]
     */
    public function getInvites(): Collection
    {
        return $this->invites;
    }

    public function addInvite(Invite $invite): self
    {
        if (!$this->invites->contains($invite)) {
            $this->invites[] = $invite;
            $invite->addGroupe($this);
        }

        return $this;
    }

    public function removeInvite(Invite $invite): self
    {
        if ($this->invites->contains($invite)) {
            $this->invites->removeElement($invite);
            $invite->removeGroupe($this);
        }

        return $this;
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
            $user->addGroupe($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeGroupe($this);
        }

        return $this;
    }
}
