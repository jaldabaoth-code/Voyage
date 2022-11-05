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
    private $userPhoto;

    /**
     * @Vich\UploadableField(mapping="poster_file", fileNameProperty="userPhoto")
     * 
     * @var File
     */
    private $userFile;

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
     * Get the value of userFile
     *
     * @return  File
     */ 
    public function getUserFile()
    {
        return $this->userFile;
    }

    /**
     * Set the value of userFile
     *
     * @param  File  $userFile
     *
     * @return  self
     */ 
    public function setUserFile(File $userFile)
    {
        $this->userFile = $userFile;

        if ($userFile) {
            $this->updatedAt = new DateTime('now');
          }
    }

    /**
     * Get the value of userPhoto
     *
     * @return  string
     */ 
    public function getUserPhoto()
    {
        return $this->userPhoto;
    }

    /**
     * Set the value of userPhoto
     *
     * @param  string  $userPhoto
     *
     * @return  self
     */ 
    public function setUserPhoto(?string $userPhoto)
    {
        $this->userPhoto = $userPhoto;

        return $this;
    }
}
