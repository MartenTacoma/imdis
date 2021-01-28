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
     * @ORM\OneToMany(targetEntity=ProgramSession::class, mappedBy="block")
     * @ORM\OrderBy({"time_start" = "ASC"})
     */
    private $session;

    public function __construct()
    {
        $this->session = new ArrayCollection();
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

    public function setSessionUrl(string $session_url): self
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
        };
        $start = strtotime($this->date->format('Y-m-d') . ' '. $this->time_start->format('H:i'));
        
        
        return $start;
    }
    
    public function __toString(){
        $string = $this->date->format('l d F') . ' '
            . $this->time_start->format('H:i') . ' - '
            . $this->time_end->format('H:i');
            
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
}
