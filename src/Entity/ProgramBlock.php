<?php

namespace App\Entity;

use App\Repository\ProgramBlockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProgramBlockRepository::class)
 */
class ProgramBlock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     */
    private $time_start;

    /**
     * @ORM\Column(type="time")
     */
    private $time_end;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $session_url;

    /**
     * @ORM\OneToMany(targetEntity=ProgramSession::class, mappedBy="block", cascade={"persist", "remove"})
     * @ORM\OrderBy({"time_start" = "ASC"})
     */
    private $session;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ZoomId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ZoomPass;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, inversedBy="programBlocks")
     */
    private $event;

    public function __construct()
    {
        $this->session = new ArrayCollection();
        $this->event = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSessionUrl(): ?string
    {
        return $this->session_url;
    }

    public function setSessionUrl(?string $session_url = null): self
    {
        $this->session_url = $session_url;

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
            $session->setBlock($this);
        }

        return $this;
    }

    public function removeSession(ProgramSession $session): self
    {
        if ($this->session->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getBlock() === $this) {
                $session->setBlock(null);
            }
        }

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
        $string = $this->date->format('l d F') . ' '
            . $this->time_start->format('H:i') . ' - '
            . $this->time_end->format('H:i');
        $events = [];
        foreach($this->getEvent() as $event){
            $events[] = $event->getAlias();
        }
        $string .= ' | ' . implode(' / ', $events);
        $themes = [];
        
        foreach($this->session as $session){
            if($session->getTheme()){
                $themes[] = $session->getTheme()->__toString();
            }
        }
        if (count($themes) > 0){
            $string .= ' | ' . implode(' / ', $themes);
        }
        return $string;
    }
    
    public function getAnchor(): string
    {
        return $this->date->format('Ymd') . $this->time_start->format('Hi');
    }

    public function getZoomId(): ?string
    {
        return $this->ZoomId;
    }

    public function setZoomId(?string $ZoomId): self
    {
        $this->ZoomId = $ZoomId;

        return $this;
    }

    public function getZoomPass(): ?string
    {
        return $this->ZoomPass;
    }

    public function setZoomPass(?string $ZoomPass): self
    {
        $this->ZoomPass = $ZoomPass;

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
