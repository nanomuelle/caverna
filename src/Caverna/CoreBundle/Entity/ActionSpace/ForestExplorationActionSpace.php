<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * @ORM\Entity;
 */
class ForestExplorationActionSpace extends ActionSpace {
    const KEY = 'ForestExploration';
    const DESCRIPTION_3_PLAYERS = 'Madera 1(1) Hortaliza +1';
    const DESCRIPTION_4_TO_7_PLAYERS = 'Madera 2(1) Comida +1';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $wood;
    
    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {
        if ($this->getGame()->getNumPlayers() < 4) {
            return self::DESCRIPTION_3_PLAYERS;
        }
        return self::DESCRIPTION_4_TO_7_PLAYERS;
    }
    
    public function getState() {
        if ($this->getGame()->getNumPlayers() < 4) {
            return 'Madera: ' . $this->getWood() . "\nHortaliza: +1";
        } else {
            return 'Madera: ' . $this->getWood() . "\nComida: +2";
        }
    }        
    
    public function __toString() {        
        if ($this->getGame()->getNumPlayers() < 4) {
            return parent::__toString() . ' (' . $this->getWood() . 'W 1H)';
        } else {
            return parent::__toString() . ' (' . $this->getWood() . 'W 2F)';
        }
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Forest Exploration');
        $this->wood = 0;
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
     * Set wood
     *
     * @param integer $wood
     *
     * @return LoggingActionSpace
     */
    public function setWood($wood)
    {
        $this->wood = $wood;

        return $this;
    }

    /**
     * Get wood
     *
     * @return integer
     */
    public function getWood()
    {
        return $this->wood;
    }
}
