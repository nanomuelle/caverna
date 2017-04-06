<?php

namespace Caverna\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity;
 */
class Dwarf {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="dwarfs", cascade="persist")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $player;

    /**
     * @ORM\Column(type="smallint")
     */
    private $num;
    
    /**
     * @ORM\Column(type="smallint")
     */
    private $armor;

    /**
     * @ORM\Column(type="boolean")
     */
    private $newborn;

    /**
     * @ORM\OneToOne(targetEntity="\Caverna\CoreBundle\Entity\ActionSpace\ActionSpace")
     */
    private $actionSpace;
    
    public function getName() {
        return $this->getPlayer()->getColor() . $this->num;
    }
    
    public function isAvailable() {
        return $this->actionSpace === null;
    }
    
    public function __toString() {
        $output = $this->getName();
        if ($this->actionSpace !== null) {
            $output .= ' [' . $this->actionSpace->getName() . ']';
        }
        
        return $output;
    }
    public function __construct() {
        $this->newborn = false;
        $this->armor = 0;
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
     * Set num
     *
     * @param integer $num
     *
     * @return Dwarf
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return integer
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set armor
     *
     * @param integer $armor
     *
     * @return Dwarf
     */
    public function setArmor($armor)
    {
        $this->armor = $armor;

        return $this;
    }

    /**
     * Get armor
     *
     * @return integer
     */
    public function getArmor()
    {
        return $this->armor;
    }

    /**
     * Set newborn
     *
     * @param boolean $newborn
     *
     * @return Dwarf
     */
    public function setNewborn($newborn)
    {
        $this->newborn = $newborn;

        return $this;
    }

    /**
     * Get newborn
     *
     * @return boolean
     */
    public function getNewborn()
    {
        return $this->newborn;
    }

    /**
     * Set player
     *
     * @param \Caverna\CoreBundle\Entity\Player $player
     *
     * @return Dwarf
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

    /**
     * Set actionSpace
     *
     * @param \Caverna\CoreBundle\Entity\ActionSpace\ActionSpace $actionSpace
     *
     * @return Dwarf
     */
    public function setActionSpace(\Caverna\CoreBundle\Entity\ActionSpace\ActionSpace $actionSpace = null)
    {
        $this->actionSpace = $actionSpace;

        return $this;
    }

    /**
     * Get actionSpace
     *
     * @return \Caverna\CoreBundle\Entity\ActionSpace\ActionSpace
     */
    public function getActionSpace()
    {
        return $this->actionSpace;
    }
}
