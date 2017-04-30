<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;
use Caverna\CoreBundle\GameEngine\TileFactory;

/**
 * Drift mining: Take all the Stone that has accumulated on this Action space. 
 * (In games with 1 to 3 players, 1 Stone will be added to this Action space 
 * every round, and 2 Stone in games with 4 to 7 players. In games with 6 to 7 
 * players, there is an additional “Drift mining” Action space accumulating 1 
 * Stone per round.) Additionally, you may place a Cavern/Tunnel twin tile on 2 
 * adjacent empty Mountain spaces of your Home board. If you place the twin tile
 * on one of the underground water sources, you will immediately get 1 or 2 Food
 * from the general supply. You have to place the twin tile adjacent to an 
 * already occupied Mountain space, i.e. you have to extend your cave system.
 * 
 * @ORM\Entity;
 */
class DriftMiningActionSpace extends ActionSpace 
{
    const KEY = 'DriftMining';
    const DESCRIPTION_1_TO_3 = 'Piedra 1(1)';
    const DESCRIPTION_4_TO_7 = 'Piedra 2(2)';
    const REPLENISH_STONE_1_TO_3_PLAYERS = 1;
    const REPLENISH_STONE_4_TO_7_PLAYERS = 2;
        
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
    
    public static function replenish() {
        if ($this->getGame()->getNumPlayers() < 4) {
            $this->addStone(self::REPLENISH_STONE_1_TO_3_PLAYERS);
        } else {
            $this->addStone(self::REPLENISH_STONE_4_TO_7_PLAYERS);
        }        
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
