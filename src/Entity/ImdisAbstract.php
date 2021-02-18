<?php

namespace App\Entity;

use App\Repository\ImdisAbstractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImdisAbstractRepository::class)
 */
class ImdisAbstract
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
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Theme::class, inversedBy="abstracts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $theme;

    /**
     * @ORM\Column(type="integer")
     */
    private $imdisId;

    /**
     * @ORM\OneToMany(targetEntity=AbstractPerson::class, mappedBy="abstract", cascade={"persist", "remove"})
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    private $people;


    /**
     * @ORM\OneToOne(targetEntity=Presentation::class, mappedBy="abstract", cascade={"persist", "remove"})
     */
    private $presentation;

    /**
     * @ORM\OneToOne(targetEntity=Poster::class, mappedBy="abstract", cascade={"persist", "remove"})
     */
    private $poster;

    public function __construct()
    {
        $this->people = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getImdisId(): ?string
    {
        return $this->imdisId;
    }

    public function setImdisId(string $imdisId): self
    {
        $this->imdisId = $imdisId;

        return $this;
    }

    /**
     * @return Collection|AbstractPerson[]
     */
    public function getPeople(): Collection
    {
        return $this->people;
    }

    public function addPerson(AbstractPerson $person): self
    {
        if (!$this->people->contains($person)) {
            $this->people[] = $person;
            $person->setAbstract($this);
        }

        return $this;
    }

    public function removePerson(AbstractPerson $person): self
    {
        if ($this->people->removeElement($person)) {
            // set the owning side to null (unless already changed)
            if ($person->getAbstract() === $this) {
                $person->setAbstract(null);
            }
        }

        return $this;
    }

    public function getPresentation(): ?Presentation
    {
        return $this->presentation;
    }

    public function setPresentation(?Presentation $presentation): self
    {
        // unset the owning side of the relation if necessary
        if ($presentation === null && $this->presentation !== null) {
            $this->presentation->setAbstract(null);
        }

        // set the owning side of the relation if necessary
        if ($presentation !== null && $presentation->getAbstract() !== $this) {
            $presentation->setAbstract($this);
        }

        $this->presentation = $presentation;

        return $this;
    }
    
    public function __toString(){
        return $this->imdisId . ' - ' . $this->title;
    }

    public function getPoster(): ?Poster
    {
        return $this->poster;
    }

    public function setPoster(Poster $poster): self
    {
        // set the owning side of the relation if necessary
        if ($poster->getAbstract() !== $this) {
            $poster->setAbstract($this);
        }

        $this->poster = $poster;

        return $this;
    }
    
    public function getUrl(): ?string{
        return 'https://imdis.seadatanet.org/files/IMDIS2021_' . $this->imdisId . '_abstract.pdf';
    }
}
