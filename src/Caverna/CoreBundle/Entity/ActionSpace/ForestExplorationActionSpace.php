<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * Forest exploration (3-7 players): Take all the Wood that has accumulated on 
 * this Action space. (In 3-player games, this Action space can be found on the
 * additional game board: every round, 1 Wood will be added to it. In games 
 * with 4 or more players, it can be found on the two-sided basic game board: 
 * every round, 1 Wood will be added to it unless it is empty. Then 2 Wood will 
 * be added to it instead.) In 3-player games, also take 1 Vegetable. In games 
 * with 4 or more players, also take 2 Food.
 * 
 * @ORM\Entity;
 */
class ForestExplorationActionSpace extends ActionSpace {
    const KEY = 'ForestExploration';
    const DESCRIPTION_3_PLAYERS = 'Madera 1(1) Hortaliza +1';
    const DESCRIPTION_4_TO_7_PLAYERS = 'Madera 2(1) Comida +1';
    const REPLENISH_WOOD = 1;    
    const INITIAL_WOOD_3_PLAYERS = 1;
    const INITIAL_WOOD_4_TO_7_PLAYERS = 2;
    
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
            return 'Madera: ' . $this->getWood() . ', Hortaliza: +1';
        } else {
            return 'Madera: ' . $this->getWood() . ', Comida: +2';
        }
    }        
    
    /**
     * 
     * @param integer $amount
     */
    public function addWood($amount) {
        $this->wood += $amount;
    }

    public static function replenish() {
        if ($this->getWood() === 0) {
            $this->setWood(
                $this->getGame()->getNumPlayers() < 4 ?
                    self::INITIAL_WOOD_3_PLAYERS :
                    self::INITIAL_WOOD_4_TO_7_PLAYERS
            );
        } else {
            $this->addWood(self::REPLENISH_WOOD);
        }
    }

    public function __construct() {
        parent::__construct();
        $this->setName('Forest Exploration');
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
