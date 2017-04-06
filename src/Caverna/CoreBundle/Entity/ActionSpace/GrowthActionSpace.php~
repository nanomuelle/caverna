<?php
namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * @ORM\Entity;
 */
class GrowthActionSpace extends ActionSpace {
    const KEY = 'Growth';
    
    const FOOD = 1;
    const WOOD = 1;
    const STONE = 1;
    const ORE = 1;
    const VP = 2;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {
        return "Comida: +1\nMadera: +1\nPieda: +1\nMineral: +1\nVP: +2\n";
    }
    
    public function getState() {
        return "Comida: +1\nMadera: +1\nPieda: +1\nMineral: +1\nVP: +2\n";
    }        
    
    public function getFood() {
        return self::FOOD;
    }
    
    public function getWood() {
        return self::WOOD;
    }
    
    public function getStone() {
        return self::STONE;
    }
    
    public function getOre() {
        return self::ORE;
    }
    
    public function getVp() {
        return self::VP;
    }
    
    public function __toString() {        
        return parent::__toString() . ' (' . 
            $this->getFood() . 'F' .
            $this->getWood() . 'W' .
            $this->getStone() . 'S' . 
            $this->getOre() . 'O' .
            $this->getVP() . 'V' .
        ')';
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Growth');
    }
}
