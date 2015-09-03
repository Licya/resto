<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proposition
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PropositionRepository")
 */
class Proposition
{

    /**
     * @var integer
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
     */
    private $title;
    
    /**
     * @var DailyMenu
     * 
     * @ORM\ManyToOne(targetEntity="DailyMenu", inversedBy="propositions")
     */
    private $dailyMenu;
    
    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="propositions", cascade={"persist"})
     */
    private $product;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Proposition
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
     * Set dailyMenu
     *
     * @param \AppBundle\Entity\DailyMenu $dailyMenu
     * @return Proposition
     */
    public function setDailyMenu(\AppBundle\Entity\DailyMenu $dailyMenu = null)
    {
        $this->dailyMenu = $dailyMenu;

        return $this;
    }

    /**
     * Get dailyMenu
     *
     * @return \AppBundle\Entity\DailyMenu 
     */
    public function getDailyMenu()
    {
        return $this->dailyMenu;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     * @return Proposition
     */
    public function setProduct(\AppBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}
