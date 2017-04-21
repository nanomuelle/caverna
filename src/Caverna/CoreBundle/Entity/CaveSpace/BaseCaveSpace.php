<?php

namespace Caverna\CoreBundle\Entity\CaveSpace;

use Doctrine\ORM\Mapping as ORM;

use Caverna\CoreBundle\Entity\Player;
use Caverna\CoreBundle\Entity\CaveSpace\MountainCaveSpace;

/**
 * @ORM\Entity;
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *      "Mountain" = "MountainCaveSpace",
 *      "Tunnel" = "TunnelCaveSpace",
 *      "Cavern" = "CavernCaveSpace",
 * 
 *      "Dwelling" = "Caverna\CoreBundle\Entity\CaveSpace\Dwelling\DwellingCaveSpace",
 *      "InitialDwelling" = "Caverna\CoreBundle\Entity\CaveSpace\Dwelling\InitialDwellingCaveSpace",
 *      "SimpleDwelling" = "Caverna\CoreBundle\Entity\CaveSpace\Dwelling\SimpleDwellingCaveSpace"
 * })
 */
abstract class BaseCaveSpace {
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
     * @ORM\ManyToOne(targetEntity="\Caverna\CoreBundle\Entity\Player", inversedBy="caveSpaces", cascade="persist")
     */
    private $player;

    public function acceptsTile($tileTipe) {
        return $this->mayDig();
    }
    
    protected function mayDig() {
        $row = $this->getRow();
        $col = $this->getCol();
        
        $caveSpace = $this->getPlayer()->getCaveSpaceByRowCol($row - 1, $col);        
        if ($caveSpace !== null && !($caveSpace instanceof MountainCaveSpace)) {
            return true;
        }

        $caveSpace = $this->getPlayer()->getCaveSpaceByRowCol($row + 1, $col);
        if ($caveSpace !== null && !($caveSpace instanceof MountainCaveSpace)) {
            return true;
        }
        
        $caveSpace = $this->getPlayer()->getCaveSpaceByRowCol($row, $col - 1);
        if ($caveSpace !== null && !($caveSpace instanceof MountainCaveSpace)) {
            return true;
        }
        
        $caveSpace = $this->getPlayer()->getCaveSpaceByRowCol($row, $col + 1);
        if ($caveSpace !== null && !($caveSpace instanceof MountainCaveSpace)) {
            return true;
        }
        
        return false;
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
     * @return BaseCaveSpace
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
     * @return BaseCaveSpace
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
     * Set player
     *
     * @param \Caverna\CoreBundle\Entity\Player $player
     *
     * @return BaseCaveSpace
     */
    public function setPlayer(\Caverna\CoreBundle\Entity\Player $player = null)
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
