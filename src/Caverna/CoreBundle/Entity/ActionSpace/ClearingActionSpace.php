<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;
use Caverna\CoreBundle\GameEngine\TileFactory;

/**
 * Clearing: Take all the Wood that has accumulated on this Action space. (In 
 * games with 1 to 3 players, 1 Wood will be added to this Action space every 
 * round, and 2 Wood in games with 4 to 7 players.) Additionally, you may place 
 * a Meadow/Field twin tile on 2 adjacent Forest spaces of your Home board that 
 * are not covered by any tiles. (Please note the remarks on Stables on page 19 
 * of the rule book.) If you place the twin tile on the small river, you will 
 * get 1 Food from the general supply. If you place the twin tile on one of the 
 * Wild boar preserves, you will get 1 Wild boar from the general supply. The 
 * first tile that you place in the game must be placed adjacent to the cave 
 * entrance. Subsequent tiles must be placed adjacent to other Fields, Meadows 
 * or Pastures.
 * 
 * @ORM\Entity;
 */
class ClearingActionSpace extends ActionSpace 
{
    const KEY = 'Clearing';
    const DESCRIPTION_1_TO_3 = "Madera 1(1)";
    const DESCRIPTION_4_TO_7 = "Madera 2(2)";
    const REPLENISH_WOOD_1_TO_3_PLAYERS = 1;
    const REPLENISH_WOOD_4_TO_7_PLAYERS = 2;
    
    
    /**
     * @var array
     */
    private $tile;
    
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
        if ($this->getGame()->getNumPlayers() < 4) {
            return self::DESCRIPTION_1_TO_3;
        }
        
        return self::DESCRIPTION_4_TO_7;
    }
    
    public function getState() {
        return 'Madera: ' . $this->getWood();
    }
    
    /**
     * @return array
     */
    public function getTile() {
        return $this->tile;
    }
    public function setTile(array $tile = null) {
        $this->tile = $tile;
        return $this;
    }
    
    public function getTileTypes() {
        return array(
            1 => TileFactory::TILE_NINGUNO, 
            2 => TileFactory::TILE_FM_HORIZONTAL, // field, meadow horizontal
            3 => TileFactory::TILE_MF_HORIZONTAL, // meadow, field horizontal
            4 => TileFactory::TILE_FM_VERTICAL, 
            5 => TileFactory::TILE_MF_VERTICAL
        );        
    }

    public function replenish() {
        if ($this->getGame()->getNumPlayers() < 4) {
            $this->addWood(self::REPLENISH_WOOD_1_TO_3_PLAYERS);
        } else {
            $this->addWood(self::REPLENISH_WOOD_4_TO_7_PLAYERS);
        }
    }
        
    public function __construct() {
        parent::__construct();
        $this->setName('Clearing');
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
