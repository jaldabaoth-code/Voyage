<?php

namespace App\Entity;

use DateTime;
use App\Entity\Photo;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PhotoRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 * @Vich\Uploadable
 */
class Photo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
      * @ORM\Column(type="string", length=255, nullable=true)
      * @var string
      */
    private $photo;

    /**
     * @Vich\UploadableField(mapping="photo_file", fileNameProperty="photo")
     * @var File
     */
    private $photoFile;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get the value of photoFile
     * @return  File
     */ 
    public function getPhotoFile()
    {
        return $this->photoFile;
    }

    /**
     * Set the value of photoFile
     * @param  File  $photoFile
     * @return  self
     */ 
    public function setPhotoFile(File $photoFile)
    {
        $this->photoFile = $photoFile;
        if ($photoFile) {
            $this->updatedAt = new DateTime('now');
        }
    }

    /**
     * Get the value of photo
     * @return  string
     */ 
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set the value of photo
     * @param  string  $photo
     * @return  self
     */ 
    public function setPhoto(?string $photo)
    {
        $this->photo = $photo;
        return $this;
    }
}
