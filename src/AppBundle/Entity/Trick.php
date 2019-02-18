<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * trick
 * @ORM\Table(name="trick")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrickRepository")
 */
class Trick
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string",name="title", length=255, nullable=false)
     */
    private $title;

    /**
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Video", mappedBy="trick", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid
     */
    private $videos;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Image", mappedBy="trick", cascade={"persist"}, orphanRemoval=true)
     */
    private $images;


    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     *
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="trick", cascade={"remove"}, orphanRemoval=true)
     */
    private $comments;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->comments = new ArrayCollection();
    }


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
     * Set title
     *
     * @param string $title
     *
     * @return Trick
     */
    public function setTitle($title)
    {
        $this->title = trim($title);
        $transliterator = \Transliterator::createFromRules(
            "::Latin-ASCII; ::Lower; [^[:L:][:N:]]+ > '-';"
        );

        $this->slug = $transliterator->transliterate($this->title);


        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set video
     *
     * @param string $videos
     *
     * @return Trick
     */
    public function setVideos($videos)
    {
        $this->videos = $videos;

        return $this;
    }

    /**
     * @param Video $video
     */
    public function addVideo(Video $video)
    {
        $video->setTrick($this);
        $this->videos->add($video);
    }

    /**
     * @param Video $video
     */
    public function removeVideo(Video $video)
    {
        $video->setTrick(null);
        $this->videos->removeElement($video);
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Trick
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param Image $picture
     */
    public function addImage(Image $picture)
    {
        $picture->setTrick($this);
        $this->images->add($picture);
    }

    /**
     * @param Image $picture
     */
    public function removeImage(Image $picture)
    {
        $picture->setTrick(null);
        $this->images->removeElement($picture);
    }



    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Trick
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set category
     *
     * @param Category $category
     *
     * @return Trick
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Get category
     *
     * @return Category|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Trick
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }


    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }
    public function addComment(Comment $comment): self

    {
        if (!$this->comments->contains($comment)){
            $this->comments[] = $comment;
            $comment->setTrick($this);
        }
        return $this;
    }
}
