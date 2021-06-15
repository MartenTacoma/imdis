<?php

namespace App\Entity;

use App\Repository\HackathonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HackathonRepository::class)
 */
class Hackathon
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=HackathonContact::class, mappedBy="hackathon", orphanRemoval=true)
     */
    private $contact;

    /**
     * @ORM\OneToMany(targetEntity=HackathonSession::class, mappedBy="hackathon", orphanRemoval=true)
     */
    private $session;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, inversedBy="hackathons")
     */
    private $event;

    public function __construct()
    {
        $this->contact = new ArrayCollection();
        $this->session = new ArrayCollection();
        $this->event = new ArrayCollection();
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|HackathonContact[]
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(HackathonContact $contact): self
    {
        if (!$this->contact->contains($contact)) {
            $this->contact[] = $contact;
            $contact->setHackathon($this);
        }

        return $this;
    }

    public function removeContact(HackathonContact $contact): self
    {
        if ($this->contact->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getHackathon() === $this) {
                $contact->setHackathon(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HackathonSession[]
     */
    public function getSession(): Collection
    {
        return $this->session;
    }

    public function addSession(HackathonSession $session): self
    {
        if (!$this->session->contains($session)) {
            $this->session[] = $session;
            $session->setHackathon($this);
        }

        return $this;
    }

    public function removeSession(HackathonSession $session): self
    {
        if ($this->session->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getHackathon() === $this) {
                $session->setHackathon(null);
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
}
