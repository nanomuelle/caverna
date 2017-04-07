<?php

namespace Caverna\CoreBundle\Entity\ForestSpace;

use Doctrine\ORM\Mapping as ORM;

use Caverna\CoreBundle\Entity\Player;

/**
 * @ORM\Entity;
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *      "Forest" = "ForestForestSpace",
 *      "Field" = "FieldForestSpace",
 *      "Meadow" = "MeadowForestSpace"
 * })
 */
abstract class BaseForestSpace {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $row;
    
    /**
     * @ORM\Column(type="smallint")
     */
    private $col;

    /**
     * @ORM\Column(type="boolean")
     */
    private $stable;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Caverna\CoreBundle\Entity\Player", inversedBy="forestSpaces", cascade="persist")
     */
    private $player;

    public function __construct() {
        $this->stable = false;
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
     * Set row
     *
     * @param integer $row
     *
     * @return BaseForestSpace
     */
    public function setRow($row)
    {
        $this->row = $row;

        return $this;
    }

    /**
     * Get row
     *
     * @return integer
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * Set col
     *
     * @param integer $col
     *
     * @return BaseForestSpace
     */
    public function setCol($col)
    {
        $this->col = $col;

        return $this;
    }

    /**
     * Get col
     *
     * @return integer
     */
    public function getCol()
    {
        return $this->col;
    }

    /**
     * Set stable
     *
     * @param boolean $stable
     *
     * @return BaseForestSpace
     */
    public function setStable($stable)
    {
        $this->stable = $stable;

        return $this;
    }

    /**
     * Get stable
     *
     * @return boolean
     */
    public function getStable()
    {
        return $this->stable;
    }

    /**
     * Set player
     *
     * @param \Caverna\CoreBundle\Entity\Player $player
     *
     * @return BaseForestSpace
     */
    public function setPlayer(Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \Caverna\CoreBundle\Entity\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }
}
