<?php

namespace BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
/**
 * Entry
 */
class Entry
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $image;

    /**
     * @var \BlogBundle\Entity\User
     */
    private $user;

    /**
     * @var \BlogBundle\Entity\Category
     */
    private $category;

    /**
     * @var \BlogBundle\Entity\Page
     */
    private $page;

    /**
     * @var integer
     */
    private $active;

    /**
     * @var date
     */
    private $date;


	protected $entryTag;
	
	public function __construct() {
		$this->entryTag = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Entry
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
     * Set content
     *
     * @param string $content
     *
     * @return Entry
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
     * Set status
     *
     * @param string $status
     *
     * @return Entry
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Entry
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set user
     *
     * @param \BlogBundle\Entity\User $user
     *
     * @return Entry
     */
    public function setUser(\BlogBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \BlogBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set category
     *
     * @param \BlogBundle\Entity\Categories $category
     *
     * @return Entry
     */
    public function setCategory(\BlogBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \BlogBundle\Entity\Categories
     */
    public function getCategory()
    {
        return $this->category;
    }
	
	public function addEntryTag(\BlogBundle\Entity\Tag $tag){
		$this->entryTag[] = $tag;
		
		return $this;
	}
	
	
	public function getEntryTag(){
		return $this->entryTag;
	}

    /**
     * Set active
     *
     * @param string $active
     *
     * @return Entry
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set date
     *
     * @param date $date
     *
     * @return Entry
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set page
     *
     * @param \BlogBundle\Entity\Page $page
     *
     * @return Entry
     */
    public function setPage(\BlogBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \BlogBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }
}

