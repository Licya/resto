<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="mainPrice", type="decimal", scale=2, nullable=true)
     */
    private $mainPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="secondPrice", type="decimal", scale=2, nullable=true)
     */
    private $secondPrice;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enable", type="boolean", nullable=true)
     */
    private $enable;

    /**
     * @ORM\OneToOne(targetEntity="Proposition")
     */
    private $proposition;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     */
    private $category;

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
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set mainPrice
     *
     * @param string $mainPrice
     * @return Product
     */
    public function setMainPrice($mainPrice)
    {
        $this->mainPrice = $mainPrice;

        return $this;
    }

    /**
     * Get mainPrice
     *
     * @return string 
     */
    public function getMainPrice()
    {
        return $this->mainPrice;
    }

    /**
     * Set secondPrice
     *
     * @param string $secondPrice
     * @return Product
     */
    public function setSecondPrice($secondPrice)
    {
        $this->secondPrice = $secondPrice;

        return $this;
    }

    /**
     * Get secondPrice
     *
     * @return string 
     */
    public function getSecondPrice()
    {
        return $this->secondPrice;
    }

    /**
     * Set enable
     *
     * @param boolean $enable
     * @return Product
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * Get enable
     *
     * @return boolean 
     */
    public function getEnable()
    {
        return $this->enable;
    }


    /**
     * Set proposition
     *
     * @param \AppBundle\Entity\Proposition $proposition
     * @return Product
     */
    public function setProposition(\AppBundle\Entity\Proposition $proposition = null)
    {
        $this->proposition = $proposition;

        return $this;
    }

    /**
     * Get proposition
     *
     * @return \AppBundle\Entity\Proposition 
     */
    public function getProposition()
    {
        return $this->proposition;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}
