<?php

namespace App\Entity;

use App\Repository\PosterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PosterRepository::class)
 */
class Poster
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=PosterSession::class, inversedBy="posters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poster_session;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video_url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment_url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $download_url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $session_url;

    /**
     * @ORM\OneToOne(targetEntity=ImdisAbstract::class, inversedBy="poster", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $abstract;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PreviewUrl;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getVideoUrl(): ?string
    {
        return $this->video_url;
    }

    public function setVideoUrl(string $video_url): self
    {
        $this->video_url = $video_url;

        return $this;
    }

    public function getCommentUrl(): ?string
    {
        return $this->comment_url;
    }

    public function setCommentUrl(?string $comment_url): self
    {
        $this->comment_url = $comment_url;

        return $this;
    }

    public function getDownloadUrl(): ?string
    {
        return $this->download_url;
    }

    public function setDownloadUrl(?string $download_url): self
    {
        $this->download_url = $download_url;

        return $this;
    }

    public function getSessionUrl(): ?string
    {
        return $this->session_url;
    }

    public function setSessionUrl(?string $session_url): self
    {
        $this->session_url = $session_url;

        return $this;
    }

    public function getAbstract(): ?ImdisAbstract
    {
        return $this->abstract;
    }

    public function setAbstract(ImdisAbstract $abstract): self
    {
        $this->abstract = $abstract;

        return $this;
    }

    public function getPreviewUrl(): ?string
    {
        return $this->PreviewUrl;
    }

    public function setPreviewUrl(string $PreviewUrl): self
    {
        $this->PreviewUrl = $PreviewUrl;

        return $this;
    }
}
