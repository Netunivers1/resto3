<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu_lists
 *
 * @ORM\Table(name="menu_lists")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Menu_listsRepository")
 */
class Menu_lists
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
     * @ORM\Column(name="id_menu", type="integer")
     */
    private $idMenu;

    /**
     * @var string
     *
     * @ORM\Column(name="menu_lists", type="string", length=255)
     */
    private $menuLists;

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
     * Set idMenu
     *
     * @param integer $idMenu
     *
     * @return Menu_lists
     */
    public function setIdMenu($idMenu)
    {
        $this->idMenu = $idMenu;

        return $this;
    }

    /**
     * Get idMenu
     *
     * @return int
     */
    public function getIdMenu()
    {
        return $this->idMenu;
    }

    /**
     * Set menuLists
     *
     * @param string $menuLists
     *
     * @return Menu_lists
     */
    public function setMenuLists($menuLists)
    {
        $this->menuLists = $menuLists;

        return $this;
    }

    /**
     * Get menuLists
     *
     * @return string
     */
    public function getMenuLists()
    {
        return $this->menuLists;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Menu_lists
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

