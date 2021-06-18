<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
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
    private $alias;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=Hackathon::class, mappedBy="event")
     */
    private $hackathons;

    /**
     * @ORM\ManyToMany(targetEntity=ProgramBlock::class, mappedBy="event")
     */
    private $programBlocks;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="event")
     */
    private $users;

    public function __construct()
    {
        $this->hackathons = new ArrayCollection();
        $this->programBlocks = new ArrayCollection();
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

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Hackathon[]
     */
    public function getHackathons(): Collection
    {
        return $this->hackathons;
    }

    public function addHackathon(Hackathon $hackathon): self
    {
        if (!$this->hackathons->contains($hackathon)) {
            $this->hackathons[] = $hackathon;
            $hackathon->addEvent($this);
        }

        return $this;
    }

    public function removeHackathon(Hackathon $hackathon): self
    {
        if ($this->hackathons->removeElement($hackathon)) {
            $hackathon->removeEvent($this);
        }

        return $this;
    }
    
    public function __toString(){
        return $this->name;
    }

    /**
     * @return Collection|ProgramBlock[]
     */
    public function getProgramBlocks(): Collection
    {
        return $this->programBlocks;
    }

    public function addProgramBlock(ProgramBlock $programBlock): self
    {
        if (!$this->programBlocks->contains($programBlock)) {
            $this->programBlocks[] = $programBlock;
            $programBlock->addEvent($this);
        }

        return $this;
    }

    public function removeProgramBlock(ProgramBlock $programBlock): self
    {
        if ($this->programBlocks->removeElement($programBlock)) {
            $programBlock->removeEvent($this);
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
            $user->addEvent($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeEvent($this);
        }

        return $this;
    }
}
