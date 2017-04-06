<?php

/*
 * Starting player: Take the Starting player token and all the Food that has 
 * accumulated on this Action space. Additionally, take 2 Ore (in games with 1 
 * to 3 players) or 1 Ruby (in games with 4 to 7 players) from the general 
 * supply. (1 Food is added to this Action space every round.) */

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;
use Caverna\CoreBundle\Entity\Player;

/**
 * @ORM\Entity;
 */
class StartingPlayerActionSpace extends ActionSpace {
    const KEY = 'StartingPlayer';
    
    const INITIAL_FOOD = 1;
    const REPLENISH_FOOD = 1;
    
    const ORE = 2;
    const RUBY = 1;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $food;
    
    public function isImitableForPlayer(Player $player) {
        return false;
    }
    
    public function getOre() {
        if ($this->getGame()->getNumPlayers() < 4) {
            return self::ORE;
        }
        
        return 0;
    }
    
    public function getRuby() {
        if ($this->getGame()->getNumPlayers() >= 4) {
            return self::RUBY;
        }
        
        return 0;
    }
    
    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {
        $description = "Jugador Inicial\nComida: 1(1)\n";
        
        if ($this->getGame()->getNumPlayers() < 4) {
            $description .= "Mineral: +2\n";
        }
        
        if ($this->getGame()->getNumPlayers() >= 4) {
            $description .= "Ruby: +1\n";
        }
        
        return $description;                
    }
    
    public function getState() {
        return $this->getDescription();
    }
    
    public function __toString() {        
        return parent::__toString() . ' (' . $this->getFood() . 'F)';
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Jugador Inicial');
        $this->food = 0;
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
