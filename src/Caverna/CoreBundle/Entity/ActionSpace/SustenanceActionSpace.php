<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;
use Caverna\CoreBundle\GameEngine\TileFactory;

/**
 * Sustenance: Take all the goods or Food markers that have accumulated on this 
 * Action space. (In games with 1 to 3 players, 1 Food will be added to this 
 * Action space every round. In games with 4 to 7 players, 1 Vegetable will be 
 * added to it every round unless it is empty. Then 1 Grain will be added to it 
 * instead.) In games with 1 to 3 players, also take 1 Grain from the general 
 * supply. Additionally, you may place a Meadow/Field twin tile on 2 adjacent 
 * Forest spaces of your Home board that are not covered by any tiles. 
 * (See “Clearing” for further details.)
 * 
 * @ORM\Entity;
 */
class SustenanceActionSpace extends ActionSpace 
{
    const KEY = 'Sustenance';
    const DESCRIPTION_1_TO_3 = "Comida: (1), Grano: +1";
    const DESCRIPTION_4_TO_7 = "Grano: 1, Hortaliza: (1)";
    
    const INITIAL_FOOD = 1;
    const GRAIN = 1;
    const REPLENISH_FOOD = 1;
    const REPLENISH_VEGETABLE = 1;
    
    /**
     * @var array
     */
    private $tile;
        
    /**
     * @ORM\Column(type="integer")
     */
    private $food;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $grain;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $vegetable;
    
    private function oneToTreePlayers() {
        return $this->getGame()->getNumPlayers() < 4;
    }
    
    public function getGrain() {
        if ($this->oneToTreePlayers()) {
            return self::GRAIN;
        }
        
        return $this->grain;
    }
    
    /**
     * @param integer $amount
     */
    public function addFood($amount) {
        $this->food += $amount;
    }
    
    /**
     * @param integer $amount
     */
    public function addVegetable($amount) {
        $this->vegetable += $amount;
    }
    
    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {
        if ($this->oneToTreePlayers()) {
            return self::DESCRIPTION_1_TO_3;
        }
        
        return self::DESCRIPTION_4_TO_7;
    }
    
    public function getState() {
        if ($this->oneToTreePlayers()) {
            return 'Comida: ' . $this->getFood() . ', Grano: ' . $this->getGrain();
        }
        return 'Grano: ' . $this->getGrain() . ', Hortaliza: ' . $this->getVegetable();
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
    
    public static function replenish(SustenanceActionSpace $actionSpace) {
        if ($actionSpace->getGame()->getNumPlayers() < 4) {
            $actionSpace->addFood(SustenanceActionSpace::REPLENISH_FOOD);
        }
        
        if ($actionSpace->getGame()->getNumPlayers() >= 4) {
            if ($actionSpace->getGrain() === 0) {
                $actionSpace->setGrain(SustenanceActionSpace::GRAIN);
            } else {
                $actionSpace->addVegetable(SustenanceActionSpace::REPLENISH_VEGETABLE);
            }
        }
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Sustenance');
        $this->food = 0;
        $this->grain = 0;
        $this->vegetable = 0;
    }

    /**
     * Set food
     *
     * @param integer $food
     *
     * @return SustenanceActionSpace
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

    /**
     * Set grain
     *
     * @param integer $grain
     *
     * @return SustenanceActionSpace
     */
    public function setGrain($grain)
    {
        $this->grain = $grain;

        return $this;
    }

    /**
     * Set vegetable
     *
     * @param integer $vegetable
     *
     * @return SustenanceActionSpace
     */
    public function setVegetable($vegetable)
    {
        $this->vegetable = $vegetable;

        return $this;
    }

    /**
     * Get vegetable
     *
     * @return integer
     */
    public function getVegetable()
    {
        return $this->vegetable;
    }
}
