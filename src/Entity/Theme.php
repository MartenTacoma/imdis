<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThemeRepository::class)
 */
class Theme
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
     * @ORM\Column(type="string", length=255)
     */
    private $tagline;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=ImdisAbstract::class, mappedBy="theme", orphanRemoval=true)
     */
    private $abstracts;

    /**
     * @ORM\OneToMany(targetEntity=ProgramSession::class, mappedBy="theme")
     */
    private $session;

    /**
     * @ORM\ManyToMany(targetEntity=PosterSession::class, mappedBy="theme")
     */
    private $posterSessions;

    public function __construct()
    {
        $this->abstracts = new ArrayCollection();
        $this->session = new ArrayCollection();
        $this->posterSessions = new ArrayCollection();
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

    public function getTagline(): ?string
    {
        return $this->tagline;
    }

    public function setTagline(string $tagline): self
    {
        $this->tagline = $tagline;

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
     * @return Collection|ImdisAbstract[]
     */
    public function getAbstracts(): Collection
    {
        return $this->abstracts;
    }

    public function addAbstract(ImdisAbstract $abstract): self
    {
        if (!$this->abstracts->contains($abstract)) {
            $this->abstracts[] = $abstract;
            $abstract->setTheme($this);
        }

        return $this;
    }

    public function removeAbstract(ImdisAbstract $abstract): self
    {
        if ($this->abstracts->removeElement($abstract)) {
            // set the owning side to null (unless already changed)
            if ($abstract->getTheme() === $this) {
                $abstract->setTheme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProgramSession[]
     */
    public function getSession(): Collection
    {
        return $this->session;
    }

    public function addSession(ProgramSession $session): self
    {
        if (!$this->session->contains($session)) {
            $this->session[] = $session;
            $session->setTheme($this);
        }

        return $this;
    }

    public function removeSession(ProgramSession $session): self
    {
        if ($this->session->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getTheme() === $this) {
                $session->setTheme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PosterSession[]
     */
    public function getPosterSessions(): Collection
    {
        return $this->posterSessions;
    }

    public function addPosterSession(PosterSession $posterSession): self
    {
        if (!$this->posterSessions->contains($posterSession)) {
            $this->posterSessions[] = $posterSession;
            $posterSession->addTheme($this);
        }

        return $this;
    }

    public function removePosterSession(PosterSession $posterSession): self
    {
        if ($this->posterSessions->removeElement($posterSession)) {
            $posterSession->removeTheme($this);
        }

        return $this;
    }
    
    public function __toString(){
        return $this->title;
    }
}
