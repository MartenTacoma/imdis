<?php

namespace App\Entity;

use App\Repository\CommitteeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommitteeRepository::class)
 */
class Committee
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
     * @ORM\OneToMany(targetEntity=CommitteePerson::class, mappedBy="committee", orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    private $people;

    public function __construct()
    {
        $this->people = new ArrayCollection();
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

    /**
     * @return Collection|CommitteePerson[]
     */
    public function getPeople(): Collection
    {
        return $this->people;
    }

    public function addPerson(CommitteePerson $person): self
    {
        if (!$this->people->contains($person)) {
            $this->people[] = $person;
            $person->setCommittee($this);
        }

        return $this;
    }

    public function removePerson(CommitteePerson $person): self
    {
        if ($this->people->removeElement($person)) {
            // set the owning side to null (unless already changed)
            if ($person->getCommittee() === $this) {
                $person->setCommittee(null);
            }
        }

        return $this;
    }
}
