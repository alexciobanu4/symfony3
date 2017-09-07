<?php

namespace BlogBundle\Entity;

/**
 * Category
 */
class Category
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    private $slug;

	protected $entry;
	
	public function __construct() {
		$this->entry = new \Doctrine\Common\Collections\ArrayCollection();
	}

	public function __toString() {
		return $this->name;
	}
	
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
     *
     * @return Category
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
     *
     * @return Category
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
	
	public function getEntries(){
		return $this->entry;
	}

    /**
     * Set slug
     *
     * @param string $name
     *
     * @return Category
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
     * Add entry
     *
     * @param \BlogBundle\Entity\Entry $entry
     *
     * @return Category
     */
    public function addEntry(\BlogBundle\Entity\Entry $entry)
    {
        $this->entry[] = $entry;

        return $this;
    }

    /**
     * Remove entry
     *
     * @param \BlogBundle\Entity\Entry $entry
     */
    public function removeEntry(\BlogBundle\Entity\Entry $entry)
    {
        $this->entry->removeElement($entry);
    }

    /**
     * Get entry
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEntry()
    {
        return $this->entry;
    }
}
