<?php

namespace App\Entity;

use App\Repository\AbstractPersonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbstractPersonRepository::class)
 */
class AbstractPerson
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ImdisAbstract::class, inversedBy="people")
     * @ORM\JoinColumn(nullable=false)
     */
    private $abstract;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPresenter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function getIsPresenter(): ?bool
    {
        return $this->isPresenter;
    }

    public function setIsPresenter(bool $isPresenter): self
    {
        $this->isPresenter = $isPresenter;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
