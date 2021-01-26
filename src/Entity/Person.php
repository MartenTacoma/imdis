<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $affiliation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $orcid;

    /**
     * @ORM\Column(type="boolean", options={"default" : false })
     */
    private $show_in_list;

    /**
     * @ORM\Column(type="boolean", options={"default" : false })
     */
    private $show_mail_in_list;

    /**
     * @ORM\OneToMany(targetEntity=AbstractPerson::class, mappedBy="person")
     */
    private $abstracts;

    /**
     * @ORM\OneToMany(targetEntity=SessionChair::class, mappedBy="person")
     */
    private $session;

    /**
     * @ORM\OneToMany(targetEntity=PresentationPerson::class, mappedBy="person")
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;
    
    /**
     * @ORM\OneToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="email", referencedColumnName="email", nullable=true)
     */
    // private $account;

    /**
     * @ORM\OneToMany(targetEntity=CommitteePerson::class, mappedBy="person", orphanRemoval=true)
     */
    private $committee;
    


    public function __construct()
    {
        $this->abstracts = new ArrayCollection();
        $this->session = new ArrayCollection();
        $this->presentation = new ArrayCollection();
        $this->committee = new ArrayCollection();
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

    public function getAffiliation(): ?string
    {
        return $this->affiliation;
    }

    public function setAffiliation(?string $affiliation): self
    {
        $this->affiliation = $affiliation;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getOrcid(): ?string
    {
        return $this->orcid;
    }

    public function setOrcid(?string $orcid): self
    {
        $this->orcid = $orcid;

        return $this;
    }

    public function getShowInList(): ?bool
    {
        return $this->show_in_list;
    }

    public function setShowInList(bool $show_in_list): self
    {
        $this->show_in_list = $show_in_list;

        return $this;
    }

    public function getShowMailInList(): ?bool
    {
        return $this->show_mail_in_list;
    }

    public function setShowMailInList(bool $show_mail_in_list): self
    {
        $this->show_mail_in_list = $show_mail_in_list;

        return $this;
    }

    /**
     * @return Collection|AbstractPerson[]
     */
    public function getAbstracts(): Collection
    {
        return $this->abstracts;
    }

    public function addAbstract(AbstractPerson $abstract): self
    {
        if (!$this->abstracts->contains($abstract)) {
            $this->abstracts[] = $abstract;
            $abstract->setPerson($this);
        }

        return $this;
    }

    public function removeAbstract(AbstractPerson $abstract): self
    {
        if ($this->abstracts->removeElement($abstract)) {
            // set the owning side to null (unless already changed)
            if ($abstract->getPerson() === $this) {
                $abstract->setPerson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SessionChair[]
     */
    public function getSession(): Collection
    {
        return $this->session;
    }

    public function addSession(SessionChair $session): self
    {
        if (!$this->session->contains($session)) {
            $this->session[] = $session;
            $session->setPerson($this);
        }

        return $this;
    }

    public function removeSession(SessionChair $session): self
    {
        if ($this->session->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getPerson() === $this) {
                $session->setPerson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PresentationPerson[]
     */
    public function getPresentation(): Collection
    {
        return $this->presentation;
    }

    public function addPresentation(PresentationPerson $presentation): self
    {
        if (!$this->presentation->contains($presentation)) {
            $this->presentation[] = $presentation;
            $presentation->setPerson($this);
        }

        return $this;
    }

    public function removePresentation(PresentationPerson $presentation): self
    {
        if ($this->presentation->removeElement($presentation)) {
            // set the owning side to null (unless already changed)
            if ($presentation->getPerson() === $this) {
                $presentation->setPerson(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
    
    public function __toString(){
        return $this->name;
    }

    /**
     * @return Collection|CommitteePerson[]
     */
    public function getCommittee(): Collection
    {
        return $this->committee;
    }

    public function addCommittee(CommitteePerson $committee): self
    {
        if (!$this->committee->contains($committee)) {
            $this->committee[] = $committee;
            $committee->setPerson($this);
        }

        return $this;
    }

    public function removeCommittee(CommitteePerson $committee): self
    {
        if ($this->committee->removeElement($committee)) {
            // set the owning side to null (unless already changed)
            if ($committee->getPerson() === $this) {
                $committee->setPerson(null);
            }
        }

        return $this;
    }
}
