<?php

namespace App\Entity;

use App\Repository\WorkingGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkingGroupRepository::class)
 */
class WorkingGroup
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=WorkingGroupContact::class, mappedBy="workingGroup", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $contact;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, inversedBy="workingGroups")
     */
    private $event;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    private $intro;

    /**
     * @ORM\OneToMany(targetEntity=Presentation::class, mappedBy="workingGroup")
     */
    private $presentations;

    /**
     * @ORM\OneToMany(targetEntity=WorkingGroupLink::class, mappedBy="workingGroup", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $links;

    public function __construct()
    {
        $this->contact = new ArrayCollection();
        $this->event = new ArrayCollection();
        $this->presentations = new ArrayCollection();
        $this->links = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description = null): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|WorkingGroupContact[]
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(WorkingGroupContact $contact): self
    {
        if (!$this->contact->contains($contact)) {
            $this->contact[] = $contact;
            $contact->setWorkingGroup($this);
        }

        return $this;
    }

    public function removeContact(WorkingGroupContact $contact): self
    {
        if ($this->contact->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getWorkingGroup() === $this) {
                $contact->setWorkingGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->event->contains($event)) {
            $this->event[] = $event;
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        $this->event->removeElement($event);

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

    public function getIntro(): ?string
    {
        return $this->intro;
    }

    public function setIntro(string $intro): self
    {
        $this->intro = $intro;

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
            $presentation->setWorkingGroup($this);
        }

        return $this;
    }

    public function removePresentation(Presentation $presentation): self
    {
        if ($this->presentations->removeElement($presentation)) {
            // set the owning side to null (unless already changed)
            if ($presentation->getWorkingGroup() === $this) {
                $presentation->setWorkingGroup(null);
            }
        }

        return $this;
    }
    
    public function __tostring(){
        return $this->title;
    }

    /**
     * @return Collection|WorkingGroupLink[]
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(WorkingGroupLink $link): self
    {
        if (!$this->links->contains($link)) {
            $this->links[] = $link;
            $link->setWorkingGroup($this);
        }

        return $this;
    }

    public function removeLink(WorkingGroupLink $link): self
    {
        if ($this->links->removeElement($link)) {
            // set the owning side to null (unless already changed)
            if ($link->getWorkingGroup() === $this) {
                $link->setWorkingGroup(null);
            }
        }

        return $this;
    }
}
