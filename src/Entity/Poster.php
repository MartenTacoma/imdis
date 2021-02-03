<?php

namespace App\Entity;

use App\Repository\PosterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PosterRepository::class)
 * @Vich\Uploadable
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
     * @ORM\OneToOne(targetEntity=ImdisAbstract::class, inversedBy="poster", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $abstract;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     */
    private $preview;
    
    /**
     * @Vich\UploadableField(mapping="poster_thumb", fileNameProperty="preview.name", size="preview.size", mimeType="preview.mimeType", originalName="preview.originalName", dimensions="preview.dimensions")
     * @var File
     */
    private $previewFile;
    
    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;
    
    private function __construct(){
        $this->preview = new EmbeddedFile();
    }
    
    public function setPreviewFile(?File $previewFile = null)
    {
        $this->previewFile = $previewFile;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($previewFile ==! null) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function setPreview(EmbeddedFile $preview): self
    {
        $this->preview = $preview;
        
        return $this;
    }
    
    public function getPreview(): ?EmbeddedFile
    {
        return $this->preview;
    }
    
    public function getpreviewFile()
    {
        return $this->previewFile;
    }

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

    public function setVideoUrl(?string $video_url): self
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

    public function getAbstract(): ?ImdisAbstract
    {
        return $this->abstract;
    }

    public function setAbstract(ImdisAbstract $abstract): self
    {
        $this->abstract = $abstract;

        return $this;
    }
    
    public function getRoomName(): ?String
    {
        $title = $this->abstract->getImdisId() . '. ' . $this->abstract->getTitle();
        if(strlen($title) > 32){
            $title = substr($title, 0, 29) . '...';
        }
        return $title;
    }
}
