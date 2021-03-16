<?php

namespace App\Entity;

use App\Repository\PosterSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PosterSessionRepository::class)
 */
class PosterSession
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Theme::class, inversedBy="posterSessions")
     */
    private $theme;

    /**
     * @ORM\OneToMany(targetEntity=Poster::class, mappedBy="poster_session", cascade={"persist", "remove"})
     */
    private $posters;

    /**
     * @ORM\OneToOne(targetEntity=Presentation::class, mappedBy="poster_session", cascade={"persist", "remove"})
     */
    private $presentation;

    /**
     * @ORM\Column(type="time")
     */
    private $time_start;

    /**
     * @ORM\Column(type="time")
     */
    private $time_end;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function __construct()
    {
        $this->theme = new ArrayCollection();
        $this->posters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Theme[]
     */
    public function getTheme(): Collection
    {
        return $this->theme;
    }

    public function addTheme(Theme $theme): self
    {
        if (!$this->theme->contains($theme)) {
            $this->theme[] = $theme;
        }

        return $this;
    }

    public function removeTheme(Theme $theme): self
    {
        $this->theme->removeElement($theme);

        return $this;
    }

    /**
     * @return Collection|Poster[]
     */
    public function getPosters(): Collection
    {
        return $this->posters;
    }

    public function addPoster(Poster $poster): self
    {
        if (!$this->posters->contains($poster)) {
            $this->posters[] = $poster;
            $poster->setPosterSession($this);
        }

        return $this;
    }

    public function removePoster(Poster $poster): self
    {
        if ($this->posters->removeElement($poster)) {
            // set the owning side to null (unless already changed)
            if ($poster->getPosterSession() === $this) {
                $poster->setPosterSession(null);
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
            $this->presentation->setPosterSession(null);
        }

        // set the owning side of the relation if necessary
        if ($presentation !== null && $presentation->getPosterSession() !== $this) {
            $presentation->setPosterSession($this);
        }

        $this->presentation = $presentation;

        return $this;
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

    public function getTimeEnd(): ?\DateTimeInterface
    {
        return $this->time_end;
    }

    public function setTimeEnd(\DateTimeInterface $time_end): self
    {
        $this->time_end = $time_end;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
    
    public function getStatus(){
        if (time() > strtotime($this->date->format('Y-m-d') . ' '. $this->time_end->format('H:i')) + 900){
            return 'past';
        } elseif (time() > strtotime($this->date->format('Y-m-d') . ' '. $this->time_start->format('H:i')) - 900) {
            return 'current';
        } else {
            return 'future';
        }
    }
    
    
    public function __toString(){
        $themes = [];
        foreach($this->theme as $theme){
            $themes[] = $theme->__toString();
        }
        return implode(' / ', $themes) . ' | ' . $this->date->format('l d F') . ' '
            . $this->time_start->format('H:i') . ' - '
            . $this->time_end->format('H:i');
    }
    
    public function getAnchor(): string
    {
        return $this->date->format('Ymd') . $this->time_start->format('Hi');
    }

}
