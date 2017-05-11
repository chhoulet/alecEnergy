<?php

namespace FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity(repositoryClass="FrontOfficeBundle\Repository\PhotoRepository")
 */
class Photo
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
    *
    * @var string
    *
    * @Assert\NotBlank()
    * @ORM\Column(name="photo", type="string", length=255)
    *
    */
    private $filename;

    /**
    *
    * @var string
    *
  
    * @ORM\ManyToOne(targetEntity="FrontOfficeBundle\Entity\Article", inversedBy="photo", cascade={"remove"})
    * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
    *
    */
    private $article;


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
     * Set filename
     *
     * @param string $filename
     *
     * @return Photo
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set article
     *
     * @param \FrontOfficeBundle\Entity\Article $article
     *
     * @return Photo
     */
    public function setArticle(\FrontOfficeBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \FrontOfficeBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
