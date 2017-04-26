<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;
use Caverna\CoreBundle\GameEngine\TileFactory;

/**
 * @ORM\Entity;
 */
class DriftMiningActionSpace extends ActionSpace 
{
    const KEY = 'DriftMining';
    const DESCRIPTION_1_TO_3 = 'Piedra 1(1)';
    const DESCRIPTION_4_TO_7 = 'Piedra 2(2)';
    
    /**
     * @var array
     */
    private $tile;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $stone;
        
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
            4 => TileFactory::TILE_TC_VERTICAL, 
            5 => TileFactory::TILE_CT_VERTICAL
        );        
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Drift Mining');
        $this->stone = 0;
        $this->tile = null;
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
