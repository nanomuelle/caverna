<?php

namespace Caverna\CoreBundle\Entity\CaveSpace;

use Doctrine\ORM\Mapping as ORM;

use Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace;
use Caverna\CoreBundle\GameEngine\TileFactory;

use Caverna\CoreBundle\Entity\CaveSpace\IRewardsPlayer;
/**
 * @ORM\Entity;
 */
class MountainCaveSpace extends BaseCaveSpace implements IRewardsPlayer {
    public function rewardsPlayer() {
        $this->getPlayer()->addFood($this->getFoodReward());
    }
    
    public function acceptsTile($tileType) {
        if (!parent::acceptsTile($tileType)) {
            return false;
        }
                
        if ($this->isExternal()) {
            return false;
        }
        
        switch ($tileType) {
            case TileFactory::TILE_CT_HORIZONTAL:
            case TileFactory::TILE_TC_HORIZONTAL:               
                $horizontalNeighbour = $this->getPlayer()->getCaveSpaceByRowCol($this->getRow(), $this->getCol() + 1);
                break;
            
            case TileFactory::TILE_CT_VERTICAL:
            case TileFactory::TILE_TC_VERTICAL:               
                $horizontalNeighbour = $this->getPlayer()->getCaveSpaceByRowCol($this->getRow() + 1, $this->getCol());
                break;
        }
        return is_a($horizontalNeighbour, MountainCaveSpace::class) && !$horizontalNeighbour->isExternal();
    }
    
    public function getFoodReward() {
        if ($this->getRow() === 1 && $this->getCol() === 2) {
            return 2;
        }
        
        if ($this->getRow() === 4 && $this->getCol() === 1) {
            return 1;
        }
        
        return 0;
    }    
    
    public function isExternal() {
        if ($this->getRow() === 0 || $this->getRow() === 5 || $this->getCol() === 3) {
            return true;
        }
        
        return false;
    }
}
