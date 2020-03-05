<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
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
     * @ORM\Column(name="email", type="string", length=180, unique=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Eventuser", mappedBy="user", cascade={"remove"})
     */
    private $evuser;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Groupe", mappedBy="user")
     */
    private $groupe;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="users", cascade={"remove"})
     * @JoinTable(name="user_user",
     *  joinColumns={@JoinColumn(name="user_source", referencedColumnName="id")},
     *  inverseJoinColumns={@JoinColumn(name="user_target", referencedColumnName="id")}
     *      )
     */
    private $friends;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="friends")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Invite", mappedBy="users")
     */
    private $invites;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Groupe", inversedBy="users")
     */
    private $grps;

    public function __construct()
    {
        $this->evuser = new ArrayCollection();
        $this->groupe = new ArrayCollection();
        $this->friends = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->invites = new ArrayCollection();
        $this->grps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Eventuser[]
     */
    public function getEvuser(): Collection
    {
        return $this->evuser;
    }

    public function addEvuser(Eventuser $evuser): self
    {
        if (!$this->evuser->contains($evuser)) {
            $this->evuser[] = $evuser;
            $evuser->setUser($this);
        }

        return $this;
    }

    public function removeEvuser(Eventuser $evuser): self
    {
        if ($this->evuser->contains($evuser)) {
            $this->evuser->removeElement($evuser);
            // set the owning side to null (unless already changed)
            if ($evuser->getUser() === $this) {
                $evuser->setUser(null);
            }
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
            $groupe->setUser($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupe->contains($groupe)) {
            $this->groupe->removeElement($groupe);
            // set the owning side to null (unless already changed)
            if ($groupe->getUser() === $this) {
                $groupe->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getFriends(): Collection
    {
        return $this->friends;
    }

    public function addFriend(self $friend): self
    {
        if (!$this->friends->contains($friend)) {
            $this->friends[] = $friend;
        }

        return $this;
    }

    public function removeFriend(self $friend): self
    {
        if ($this->friends->contains($friend)) {
            $this->friends->removeElement($friend);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(self $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addFriend($this);
        }

        return $this;
    }

    public function removeUser(self $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeFriend($this);
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
            $invite->addUser($this);
        }

        return $this;
    }

    public function removeInvite(Invite $invite): self
    {
        if ($this->invites->contains($invite)) {
            $this->invites->removeElement($invite);
            $invite->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGrps(): Collection
    {
        return $this->grps;
    }

    public function addGrp(Groupe $grp): self
    {
        if (!$this->grps->contains($grp)) {
            $this->grps[] = $grp;
        }

        return $this;
    }

    public function removeGrp(Groupe $grp): self
    {
        if ($this->grps->contains($grp)) {
            $this->grps->removeElement($grp);
        }

        return $this;
    }
}
