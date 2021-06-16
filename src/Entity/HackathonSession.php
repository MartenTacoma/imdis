<?php

namespace App\Entity;

use App\Repository\HackathonSessionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HackathonSessionRepository::class)
 */
class HackathonSession
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Hackathon::class, inversedBy="session")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hackathon;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     */
    private $timeStart;

    /**
     * @ORM\Column(type="time")
     */
    private $timeEnd;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $meetingUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $meetingId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $meetingPasscode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHackathon(): ?Hackathon
    {
        return $this->hackathon;
    }

    public function setHackathon(?Hackathon $hackathon): self
    {
        $this->hackathon = $hackathon;

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

    public function getTimeStart(): ?\DateTimeInterface
    {
        return $this->timeStart;
    }

    public function setTimeStart(\DateTimeInterface $timeEnd): self
    {
        $this->timeStart = $timeEnd;

        return $this;
    }

    public function getTimeEnd(): ?\DateTimeInterface
    {
        return $this->timeEnd;
    }

    public function setTimeEnd(\DateTimeInterface $timeEnd): self
    {
        $this->timeEnd = $timeEnd;

        return $this;
    }

    public function getMeetingUrl(): ?string
    {
        return $this->meetingUrl;
    }

    public function setMeetingUrl(?string $meetingUrl): self
    {
        $this->meetingUrl = $meetingUrl;

        return $this;
    }

    public function getMeetingId(): ?string
    {
        return $this->meetingId;
    }

    public function setMeetingId(?string $meetingId): self
    {
        $this->meetingId = $meetingId;

        return $this;
    }

    public function getMeetingPasscode(): ?string
    {
        return $this->meetingPasscode;
    }

    public function setMeetingPasscode(string $meetingPasscode): self
    {
        $this->meetingPasscode = $meetingPasscode;

        return $this;
    }
}
