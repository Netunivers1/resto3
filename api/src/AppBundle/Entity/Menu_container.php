<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu_container
 *
 * @ORM\Table(name="menu_container")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Menu_containerRepository")
 */
class Menu_container
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
     * @ORM\Column(name="menu_title", type="string", length=255)
     */
    private $menuTitle;

    /**
     * @var int
     *
     * @ORM\Column(name="classifier", type="integer", nullable=true)
     */
    private $classifier;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;


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
     * Set menuTitle
     *
     * @param string $menuTitle
     *
     * @return Menu_container
     */
    public function setMenuTitle($menuTitle)
    {
        $this->menuTitle = $menuTitle;

        return $this;
    }

    /**
     * Get menuTitle
     *
     * @return string
     */
    public function getMenuTitle()
    {
        return $this->menuTitle;
    }

    /**
     * Set classifier
     *
     * @param integer $classifier
     *
     * @return Menu_container
     */
    public function setClassifier($classifier)
    {
        $this->classifier = $classifier;

        return $this;
    }

    /**
     * Get classifier
     *
     * @return int
     */
    public function getClassifier()
    {
        return $this->classifier;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Menu_container
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
}

