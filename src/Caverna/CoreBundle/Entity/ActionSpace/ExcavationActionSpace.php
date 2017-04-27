<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;
use Caverna\CoreBundle\GameEngine\TileFactory;

/**
 * @ORM\Entity;
 */
class ExcavationActionSpace extends ActionSpace {
    const KEY = 'Excavation';
    const DESCRIPTION_1_TO_3 = 'Piedra 1(1)';
    const DESCRIPTION_4_TO_7 = 'Piedra 2(1)';
    
    /**
     * @ORM\Column(type="integer")
     */
    private $stone;
    
    /**
     * @var array
     */
    private $tile;
        
    public function getKey() {
        return self::KEY;
    }
    
    public function addStone($amount) {
        $this->stone += $amount;
    }
    
    public function getDescription() {
        if ($this->getGame()->getNumPlayers() < 4) {
            return self::DESCRIPTION_1_TO_3;
        }
        return self::DESCRIPTION_4_TO_7;
    }
    
    public function getState() {
        return 'Piedra: ' . $this->getStone();
    }

    /**
     * @return array
     */
    public function getTile() {
        return $this->tile;
    }
    public function setTile(array $tile) {
        $this->tile = $tile;
        return $this;
    }
     
    public function getTileTypes() {
        return array(
            1 => TileFactory::TILE_NINGUNO, 
            2 => TileFactory::TILE_TC_HORIZONTAL, 
            3 => TileFactory::TILE_CT_HORIZONTAL, 
            4 => TileFactory::TILE_CC_HORIZONTAL,
            5 => TileFactory::TILE_TC_VERTICAL, 
            6 => TileFactory::TILE_CT_VERTICAL,
            7 => TileFactory::TILE_CC_VERTICAL            
        );
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Excavation');
        $this->stone = 0;
    }

    /**
     * Set stone
     *
     * @param integer $stone
     *
     * @return DriftMiningActionSpace
     */
    public function setStone($stone)
    {
        $this->stone = $stone;

        return $this;
    }

    /**
     * Get stone
     *
     * @return integer
     */
    public function getStone()
    {
        return $this->stone;
    }
}
