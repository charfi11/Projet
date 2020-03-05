<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TropheeRepository")
 */
class Trophee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Eventuser", mappedBy="trophee", cascade={"remove"})
     */
    private $win;

    public function __construct()
    {
        $this->win = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|Eventuser[]
     */
    public function getWin(): Collection
    {
        return $this->win;
    }

    public function addWin(Eventuser $win): self
    {
        if (!$this->win->contains($win)) {
            $this->win[] = $win;
            $win->setTrophee($this);
        }

        return $this;
    }

    public function removeWin(Eventuser $win): self
    {
        if ($this->win->contains($win)) {
            $this->win->removeElement($win);
            // set the owning side to null (unless already changed)
            if ($win->getTrophee() === $this) {
                $win->setTrophee(null);
            }
        }

        return $this;
    }
}
