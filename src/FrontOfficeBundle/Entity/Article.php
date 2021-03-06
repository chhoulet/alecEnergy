<?php

namespace FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="FrontOfficeBundle\Repository\ArticleRepository")
 */
class Article
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Votre titre ne doit pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Votre titre ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=355, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 355,
     *      minMessage = "Votre sujet ne doit pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Votre sujet ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="main", type="text", length=15550)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 15550,
     *      minMessage = "Votre article ne doit pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Votre article ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    private $main;

    /**
     * @var bigint
     *
     * @ORM\Column(name="dateCreated", type="bigint")
     */
    private $dateCreated;

    /**
     * @var bigint
     *
     * @ORM\Column(name="dateDeleted", type="bigint", nullable=true)
     */
    private $dateDeleted;

    /**
     * @var int
     *
     * @ORM\Column(name="origin", type="smallint")
     */
    private $origin;

     /**
     * @var int
     *
     * @ORM\Column(name="active", type="smallint")
     */
    private $active=1;

     /**
     *
     *
     * @ORM\OneToMany(targetEntity="FrontOfficeBundle\Entity\Photo", mappedBy="article")
     */
    private $photo;


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
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
     * Set subject
     *
     * @param string $subject
     *
     * @return Article
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set main
     *
     * @param string $main
     *
     * @return Article
     */
    public function setMain($main)
    {
        $this->main = $main;

        return $this;
    }

    /**
     * Get main
     *
     * @return string
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Article
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set origin
     *
     * @param integer $origin
     *
     * @return Article
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin
     *
     * @return int
     */
    public function getOrigin()
    {
        return $this->origin;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add photo
     *
     * @param \FrontOfficeBundle\Entity\Photo $photo
     *
     * @return Article
     */
    public function addPhoto(\FrontOfficeBundle\Entity\Photo $photo)
    {
        $this->photo[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \FrontOfficeBundle\Entity\Photo $photo
     */
    public function removePhoto(\FrontOfficeBundle\Entity\Photo $photo)
    {
        $this->photo->removeElement($photo);
    }

    /**
     * Get photo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set active
     *
     * @param integer $active
     *
     * @return Article
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set dateDeleted
     *
     * @param \DateTime $dateDeleted
     *
     * @return Article
     */
    public function setDateDeleted($dateDeleted)
    {
        $this->dateDeleted = $dateDeleted;

        return $this;
    }

    /**
     * Get dateDeleted
     *
     * @return \DateTime
     */
    public function getDateDeleted()
    {
        return $this->dateDeleted;
    }
}
