<?php

namespace App\Entity;

use App\Repository\PresentationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PresentationRepository::class)
 */
class Presentation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ProgramSession::class, inversedBy="presentations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $program_session;

    /**
     * @ORM\OneToOne(targetEntity=ImdisAbstract::class, inversedBy="presentation", cascade={"persist", "remove"})
     */
    private $abstract;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="time")
     */
    private $time_start;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video_url;

    /**
     * @ORM\ManyToOne(targetEntity=PresentationType::class, inversedBy="presentations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity=PosterSession::class, inversedBy="presentation", cascade={"persist", "remove"})
     */
    private $poster_session;

    /**
     * @ORM\OneToMany(targetEntity=PresentationPerson::class, mappedBy="presentation", orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    private $presentationPeople;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slides_url;

    /**
     * @ORM\OneToMany(targetEntity=UserPresentation::class, mappedBy="presentation", orphanRemoval=true)
     */
    private $users;

    public function __construct()
    {
        $this->presentationPeople = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgramSession(): ?ProgramSession
    {
        return $this->program_session;
    }

    public function setProgramSession(?ProgramSession $program_session): self
    {
        $this->program_session = $program_session;

        return $this;
    }

    public function getAbstract(): ?ImdisAbstract
    {
        return $this->abstract;
    }

    public function setAbstract(?ImdisAbstract $abstract): self
    {
        $this->abstract = $abstract;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    public function getVideoUrl(): ?string
    {
        return $this->video_url;
    }

    public function setVideoUrl(?string $video_url): self
    {
        $this->video_url = $video_url;

        return $this;
    }

    public function getType(): ?PresentationType
    {
        return $this->type;
    }

    public function setType(?PresentationType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPosterSession(): ?PosterSession
    {
        return $this->poster_session;
    }

    public function setPosterSession(?PosterSession $poster_session): self
    {
        $this->poster_session = $poster_session;

        return $this;
    }

    /**
     * @return Collection|PresentationPerson[]
     */
    public function getPresentationPeople(): Collection
    {
        return $this->presentationPeople;
    }

    public function addPresentationPerson(PresentationPerson $presentationPerson): self
    {
        if (!$this->presentationPeople->contains($presentationPerson)) {
            $this->presentationPeople[] = $presentationPerson;
            $presentationPerson->setPresentation($this);
        }

        return $this;
    }

    public function removePresentationPerson(PresentationPerson $presentationPerson): self
    {
        if ($this->presentationPeople->removeElement($presentationPerson)) {
            // set the owning side to null (unless already changed)
            if ($presentationPerson->getPresentation() === $this) {
                $presentationPerson->setPresentation(null);
            }
        }

        return $this;
    }
    
    public function __toString(){
        return empty($this->abstract) ? $this->title : $this->abstract->__toString();
    }
    
    public function getTheTitle(){
        if(!empty($this->abstract)) {
            return $this->abstract->getTitle();
        } elseif (!empty($this->poster_session)) {
            return $this->poster_session->__toString();
        } else {
            return $this->title;
        }
    }

    public function getSlidesUrl(): ?string
    {
        return $this->slides_url;
    }

    public function setSlidesUrl(?string $slides_url): self
    {
        $this->slides_url = $slides_url;

        return $this;
    }

    /**
     * @return Collection|UserPresentation[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(UserPresentation $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setPresentation($this);
        }

        return $this;
    }

    public function removeUser(UserPresentation $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getPresentation() === $this) {
                $user->setPresentation(null);
            }
        }

        return $this;
    }
}
