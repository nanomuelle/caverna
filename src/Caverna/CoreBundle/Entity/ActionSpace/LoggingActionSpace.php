<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * Logging: Take all the Wood that has accumulated on this Action space. (In 
 * games with 1 to 3 players, 1 Wood will be added to this Action space every 
 * round unless it is empty. Then 3 Wood will be added to it instead. In games 
 * with 4 to 7 players, 3 Wood will be added to it every round regardless of 
 * whether it is empty or not.) 
 * Afterwards, you may undertake a Level 1 expedition if your Dwarf has 
 * a Weapon.
 * 
 * @ORM\Entity;
 */
class LoggingActionSpace extends ActionSpace {
    const KEY = 'Logging';
    const INITIAL_WOOD = 3;
    const REPLENISH_WOOD_1_TO_3_PLAYERS = 1;
    const REPLENISH_WOOD_4_TO_7_PLAYERS = 3;   

    /**
     * @ORM\Column(type="integer")
     */
    private $wood;
    
    /**
     * 
     * @param integer $amount
     */
    public function addWood($amount) {
        $this->wood += $amount;
    }
    
    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {
        return 'Madera: 3(3)';
    }
    
    public function getState() {
        return 'Madera: ' . $this->getWood();
    }      
    
    public static function replenish() {
        if ($this->getWood() > 0) {
            if ($this->getGame()->getNumPlayers() < 4) {
                $this->addWood(self::REPLENISH_WOOD_1_TO_3_PLAYERS);
            } else {
                $this->addWood(self::REPLENISH_WOOD_4_TO_7_PLAYERS);
            }
        } else {
            $this->setWood(self::INITIAL_WOOD);            
        }
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Logging');
        $this->wood = 0;
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
