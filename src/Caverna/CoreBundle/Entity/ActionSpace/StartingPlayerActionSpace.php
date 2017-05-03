<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;
use Caverna\CoreBundle\Entity\Player;

/**
 * Starting player: Take the Starting player token and all the Food that has 
 * accumulated on this Action space. Additionally, take 2 Ore (in games 
 * with 1 to 3 players) or 1 Ruby (in games with 4 to 7 players) from the 
 * general supply. (1 Food is added to this Action space every round.)
 * 
 * @ORM\Entity;
 */
class StartingPlayerActionSpace extends ActionSpace {
    const KEY = 'StartingPlayer';
    const DESCRIPTION = 'Jugador Inicial, Comida 1(1)';
    const REPLENISH_FOOD = 1;

    /**
     * @ORM\Column(type="integer")
     */
    private $food;
    
    public function isImitableForPlayer(Player $player) {
        return false;
    }
        
    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {        
        if ($this->getGame()->getNumPlayers() < 4) {
            return self::DESCRIPTION . ', Mineral +2';
        }
        
        return self::DESCRIPTION . ', Ruby +1';
    }
    
    public function getState() {
        if ($this->getGame()->getNumPlayers() < 4) {
            return 'Jugador Inicial, Comida: ' . $this->getFood() . ', Mineral +2';
        }
        return 'Jugador Inicial, Comida: ' . $this->getFood() . ', Ruby +1';
    }
    
    /**
     * 
     * @param integer $amount
     */
    public function addFood($amount) {
        $this->food += $amount;
    } 
    
    public function replenish() {
        $this->addFood(self::REPLENISH_FOOD);
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Jugador Inicial');
        $this->food = 0;
    }

    /**
     * Set food
     *
     * @param integer $food
     *
     * @return StartingPlayerActionSpace
     */
    public function setFood($food)
    {
        $this->food = $food;

        return $this;
    }

    /**
     * Get food
     *
     * @return integer
     */
    public function getFood()
    {
        return $this->food;
    }

}
