<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;
use Caverna\CoreBundle\GameEngine\TileFactory;

/**
 * Excavation: Take all the Stone that has accumulated on this Action space. 
 * (1 Stone will be added to this Action space every round unless, in games 
 * with 4 to 7 players only, there is no Stone on it. Then 2 Stone will be 
 * added to it instead.) Additionally, you may place a Cavern/Tunnel or a 
 * Cavern/Cavern twin tile on 2 adjacent empty Mountain spaces of your Home 
 * board. You decide which side of the twin tile you want to use. If you place 
 * the twin tile on one of the underground water sources, you will immediately 
 * get 1 or 2 Food from the general supply. You have to place the twin tile 
 * adjacent to an already occupied Mountain space, i.e. you have to extend your 
 * cave system.
 * 
 * @ORM\Entity;
 */
class ExcavationActionSpace extends ActionSpace {
    const KEY = 'Excavation';
    const DESCRIPTION_1_TO_3 = 'Piedra 1(1)';
    const DESCRIPTION_4_TO_7 = 'Piedra 2(1)';
    const REPLENISH_STONE = 1;
    const INITIAL_STONE_1_TO_3 = 1;
    const INITIAL_STONE_4_TO_7 = 2;
        
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
    
    public static function replenish() {
        if ($this->getStone() === 0) {
            $this->setStone( 
                $this->getGame()->getNumPlayers() < 4 ? 
                self::INITIAL_STONE_1_TO_3 : 
                self::INITIAL_STONE_4_TO_7 
            );
        } else {
            $this->addStone(self::REPLENISH_STONE);
        }
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
