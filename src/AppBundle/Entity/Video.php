<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VideoRepository")
 */
class Video
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Trick", inversedBy="video")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $trick;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     * @Assert\File(
     *     mimeTypesMessage = "La vidéo doit prevenir de youtube ou dailymotion."
     * )
     */
    private $url;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get trick
     *
     * @return int
     */
    public function getTrick()
    {
        return $this->trick;
    }

    /**
     * Set trick
     *
     * @param integer $trick
     *
     * @return Video
     */
    public function setTrick($trick)
    {
        $this->trick = $trick;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Video
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preAdd()
    {
        if (null === $this->url) {
            return;
        }
        if (preg_match('/youtube/', $this->url, $matches)) {
            $url = str_replace("watch?v=", "embed/", $this->url);
            $this->url = $url;
        } elseif (preg_match('/dailymotion/', $this->url, $matches)) {
            $url = str_replace('https://', '//', $this->url);
            $url = str_replace('/video/', '/embed/video/', $url);
            $this->url = $url;
        } else {
            $this->url = '';
        }
    }
}

