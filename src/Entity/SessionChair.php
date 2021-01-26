<?php

namespace App\Entity;

use App\Repository\SessionChairRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionChairRepository::class)
 */
class SessionChair
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ProgramSession::class, inversedBy="chair")
     * @ORM\JoinColumn(nullable=false)
     */
    private $session;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="session")
     * @ORM\JoinColumn(nullable=false)
     */
    private $person;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSession(): ?ProgramSession
    {
        return $this->session;
    }

    public function setSession(?ProgramSession $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }
    
    public function __toString(){
        return $this->person->__toString();
    }
}
