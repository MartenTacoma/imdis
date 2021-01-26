<?php

namespace App\Entity;

use App\Repository\ProgramSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProgramSessionRepository::class)
 */
class ProgramSession
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ProgramBlock::class, inversedBy="session")
     * @ORM\JoinColumn(nullable=false)
     */
    private $block;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Theme::class, inversedBy="session")
     */
    private $theme;

    /**
     * @ORM\OneToMany(targetEntity=SessionChair::class, mappedBy="session", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    private $chair;

    /**
     * @ORM\OneToMany(targetEntity=Presentation::class, mappedBy="program_session")
     * @ORM\OrderBy({"time_start" = "ASC"})
     */
    private $presentations;

    /**
     * @ORM\Column(type="time")
     */
    private $time_start;

    public function __construct()
    {
        $this->chair = new ArrayCollection();
        $this->presentations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlock(): ?ProgramBlock
    {
        return $this->block;
    }

    public function setBlock(?ProgramBlock $block): self
    {
        $this->block = $block;

        return $this;
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

    /**
     * @return Collection|SessionChair[]
     */
    public function getChair(): Collection
    {
        return $this->chair;
    }

    public function addChair(SessionChair $chair): self
    {
        if (!$this->chair->contains($chair)) {
            $this->chair[] = $chair;
            $chair->setSession($this);
        }

        return $this;
    }

    public function removeChair(SessionChair $chair): self
    {
        if ($this->chair->removeElement($chair)) {
            // set the owning side to null (unless already changed)
            if ($chair->getSession() === $this) {
                $chair->setSession(null);
            }
        }

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
            $presentation->setProgramSession($this);
        }

        return $this;
    }

    public function removePresentation(Presentation $presentation): self
    {
        if ($this->presentations->removeElement($presentation)) {
            // set the owning side to null (unless already changed)
            if ($presentation->getProgramSession() === $this) {
                $presentation->setProgramSession(null);
            }
        }

        return $this;
    }
    
    public function __toString(){
        $string = $this->block->__toString(). ' | ';
        if(!empty($this->title)) {
            $string .= $this->title;
        } else {
            $string .= $this->theme->__toString();
        }
        return $string;
    }

    public function getTimeStart(): ?\DateTimeInterface
    {
        return $this->time_start;
    }

    public function setTimeStart(\DateTimeInterface $time_start): self
    {
        $this->time_start = $time_start;

        return $this;
    }
}
