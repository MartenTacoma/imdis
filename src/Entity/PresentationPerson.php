<?php

namespace App\Entity;

use App\Repository\PresentationPersonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PresentationPersonRepository::class)
 */
class PresentationPerson
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Presentation::class, inversedBy="presentationPeople")
     * @ORM\JoinColumn(nullable=false)
     */
    private $presentation;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="presentation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $person;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @ORM\Column(type="boolean")
     */
    private $presenter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresentation(): ?Presentation
    {
        return $this->presentation;
    }

    public function setPresentation(?Presentation $presentation): self
    {
        $this->presentation = $presentation;

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

    public function getPresenter(): ?bool
    {
        return $this->presenter;
    }

    public function setPresenter(bool $presenter): self
    {
        $this->presenter = $presenter;

        return $this;
    }
}
