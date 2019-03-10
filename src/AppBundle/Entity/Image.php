<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * image
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * ^
     */
    private $id;

    /**
     * Relation with trick
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Trick", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;

    /**
     * Url of image
     *
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * Alt of image
     *
     * @ORM\Column(type="string", length=255)
     */
    private $alt;


    /**
     * Image file
     *
     * @var File
     *
     * @Assert\File(
     *     maxSize = "10000k",
     *     maxSizeMessage = "Taille maximale autorisée : 10 Mo.",
     *     mimeTypes = {"image/png", "image/jpg", "image/jpeg"},
     *     mimeTypesMessage = "Format accepté : jpg, jpeg, png."
     * )
     */
    private $file;

    /**
     * Image tempfile
     *
     * @var string
     */
    private $tempFilename;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null === $this->file) {
            return;
        }

        $this->url = $this->file->guessExtension();
        $this->alt = $this->file->getClientOriginalName();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        if (null !== $this->tempFilename) {
            $oldFile = $this->getUploadRootDir() . '/' . $this->id . '.' . $this->tempFilename;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $this->file->move(
            $this->getUploadRootDir(),
            $this->id . '.' . $this->url
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        $this->tempFilename = $this->getUploadRootDir() . '/' . $this->id . '.' . $this->url;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (file_exists($this->tempFilename)) {
            unlink($this->tempFilename);
        }
    }

    /**
     * @return string
     */
    public function getWebPath()
    {
        return $this->getUploadDir() . '/' . $this->getId() . '.' . $this->getUrl();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getTrick()
    {
        return $this->trick;
    }

    public function setTrick($trick)
    {
        $this->trick = $trick;

        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function getAlt()
    {
        return $this->alt;
    }

    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        if (null !== $this->url) {
            $this->tempFilename = $this->url;

            $this->url = null;
            $this->alt = null;
        }
    }

    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__ . '../../../../web/' . $this->getUploadDir();
    }

    /**
     * @return string
     */
    public function getUploadDir()
    {
        return 'assets/images';
    }
}
