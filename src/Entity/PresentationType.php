<?php

namespace App\Entity;

use App\Repository\PresentationTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PresentationTypeRepository::class)
 */
class PresentationType
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
    private $label;

    /**
     * @ORM\Column(type="json")
     */
    private $fields_required = [];

    /**
     * @ORM\Column(type="json")
     */
    private $fields_not_allowed = [];

    /**
     * @ORM\OneToMany(targetEntity=Presentation::class, mappedBy="type")
     */
    private $presentations;

    public function __construct()
    {
        $this->presentations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getFieldsRequired(): ?array
    {
        return $this->fields_required;
    }

    public function setFieldsRequired(array $fields_required): self
    {
        $this->fields_required = $fields_required;

        return $this;
    }

    public function getFieldsNotAllowed(): ?array
    {
        return $this->fields_not_allowed;
    }

    public function setFieldsNotAllowed(array $fields_not_allowed): self
    {
        $this->fields_not_allowed = $fields_not_allowed;

        return $this;
    }

    /**
     * @return Collection|Presentation[]
     */
    public function getPresentations(): Collection
    {
        return $this->presentations;
    }

    public function addPresentation(Presentation $presentation): self
    {
        if (!$this->presentations->contains($presentation)) {
            $this->presentations[] = $presentation;
            $presentation->setType($this);
        }

        return $this;
    }

    public function removePresentation(Presentation $presentation): self
    {
        if ($this->presentations->removeElement($presentation)) {
            // set the owning side to null (unless already changed)
            if ($presentation->getType() === $this) {
                $presentation->setType(null);
            }
        }

        return $this;
    }
    
    public function __toString(){
        return $this->label;
    }
}
