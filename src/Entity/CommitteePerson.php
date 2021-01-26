<?php

namespace App\Entity;

use App\Repository\CommitteePersonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommitteePersonRepository::class)
 */
class CommitteePerson
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Committee::class, inversedBy="people")
     * @ORM\JoinColumn(nullable=false)
     */
    private $committee;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="committee")
     * @ORM\JoinColumn(nullable=false)
     */
    private $person;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommittee(): ?Committee
    {
        return $this->committee;
    }

    public function setCommittee(?Committee $committee): self
    {
        $this->committee = $committee;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }
}
