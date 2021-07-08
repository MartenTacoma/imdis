<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Controller\UserController;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;
    
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="datetime", options={"default" : "CURRENT_TIMESTAMP" })
     */
    private $registration_time;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $affiliation;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="users")
     * @ORM\JoinColumn(name="country", referencedColumnName="id")
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $show_in_list;

    /**
     * @ORM\Column(type="boolean")
     */
    private $show_email=false;

    /**
     * @ORM\OneToMany(targetEntity=UserPresentation::class, mappedBy="user", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $presentations;

    /**
     * @ORM\OneToMany(targetEntity=UserPoster::class, mappedBy="user", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $posters;

    /**
     * @ORM\Column(type="boolean")
     */
    private $maillist;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, inversedBy="users")
     */
    private $event;

    public function __construct(){
        if(empty($this->registration_time)){
            $this->registration_time = new \DateTime();
        }
        $this->presentations = new ArrayCollection();
        $this->posters = new ArrayCollection();
        $this->event = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getRegistrationTime(): ?\DateTimeInterface
    {
        return $this->registration_time;
    }

    public function setRegistrationTime(\DateTimeInterface $registration_time): self
    {
        $this->registration_time = $registration_time;

        return $this;
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

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }
    
    public function getShowInList(): ?string
    {
        return $this->show_in_list;
    }

    public function setShowInList(string $show_in_list): self
    {
        $this->show_in_list = $show_in_list;

        return $this;
    }

    public function getShowEmail(): ?bool
    {
        return $this->show_email;
    }

    public function setShowEmail(bool $show_email): self
    {
        $this->show_email = $show_email;

        return $this;
    }

    /**
     * @return Collection|UserPresentation[]
     */
    public function getPresentations(): Collection
    {
        return $this->presentations;
    }

    public function addPresentation(UserPresentation $presentation): self
    {
        if (!$this->presentations->contains($presentation)) {
            $this->presentations[] = $presentation;
            $presentation->setUser($this);
        }

        return $this;
    }

    public function removePresentation(UserPresentation $presentation): self
    {
        if ($this->presentations->removeElement($presentation)) {
            // set the owning side to null (unless already changed)
            if ($presentation->getUser() === $this) {
                $presentation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserPoster[]
     */
    public function getPosters(): Collection
    {
        return $this->posters;
    }

    public function addPoster(UserPoster $poster): self
    {
        if (!$this->posters->contains($poster)) {
            $this->posters[] = $poster;
            $poster->setUser($this);
        }

        return $this;
    }

    public function removePoster(UserPoster $poster): self
    {
        if ($this->posters->removeElement($poster)) {
            // set the owning side to null (unless already changed)
            if ($poster->getUser() === $this) {
                $poster->setUser(null);
            }
        }

        return $this;
    }

    public function getMaillist(): ?bool
    {
        return $this->maillist;
    }

    public function setMaillist(bool $maillist): self
    {
        $this->maillist = $maillist;

        return $this;
    }
    
    public function getRegistrationType(){
        $types = [
            true => [true => 'both', false => 'oral'],
            false => [true => 'poster', false => 'no']
        ];
        return $types[count($this->presentations) > 0][count($this->posters) > 0];
    }
    
    public function getRoleLabels(){
        $return = [];
        foreach ($this->roles as $role) {
            $return[] = array_search($role, UserController::$roles);
        }
        return $return;
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
