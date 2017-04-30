<?php
namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * Growth (4-7 players): Take 1 Wood, 1 Stone, 1 Ore, 1 Food and 2 Gold from the
 *  general supply. Alternatively, carry out a Family growth action.
 * 
 * @ORM\Entity;
 */
class GrowthActionSpace extends ActionSpace {
    const KEY = 'Growth';
    
    const FOOD = 1;
    const WOOD = 1;
    const STONE = 1;
    const ORE = 1;
    const VP = 2;
    
    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {
        return 'Comida: +1, Madera: +1, Pieda: +1, Mineral: +1, Vp: +2';
    }
    
    public function getState() {
        return 'Comida: +1, Madera: +1, Pieda: +1, Mineral: +1, Vp: +2';
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

    public static function replenish() {
        return;
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Growth');
    }
}
