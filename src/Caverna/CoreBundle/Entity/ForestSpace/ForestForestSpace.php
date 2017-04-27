<?php

namespace Caverna\CoreBundle\Entity\ForestSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ForestSpace\BaseForestSpace;

use Caverna\CoreBundle\GameEngine\TileFactory;
/**
 * @ORM\Entity;
 */
class ForestForestSpace extends BaseForestSpace {    
    public function acceptsTile($tileType) {
        switch ($tileType) {
            case TileFactory::TILE_F:
            case TileFactory::TILE_M:
                return parent::acceptsTile($tileType);
            
            case TileFactory::TILE_FM_HORIZONTAL:
            case TileFactory::TILE_MF_HORIZONTAL:
                $sideForestSpace = $this->getPlayer()->getForestSpaceByRowCol($this->getRow(), $this->getCol() + 1);
                break;
            
            case TileFactory::TILE_FM_VERTICAL:
            case TileFactory::TILE_MF_VERTICAL:
                $sideForestSpace = $this->getPlayer()->getForestSpaceByRowCol($this->getRow() + 1, $this->getCol());
                break;            
        }
        
        // sideForestSpace is ForestForestSpace
        if (!$sideForestSpace instanceof ForestForestSpace) {
            return false;
        }

        // sideForestSpace is not external
        if ($sideForestSpace->isExternal()) {
            return false;
        }                

        return parent::acceptsTile(TileFactory::TILE_F) || $sideForestSpace->acceptsTile(TileFactory::TILE_F);        
    }
    
    /**
     * @return int
     */
    public function getBoarReward() {
        if ($this->getRow() === 1 && $this->getCol() === 3) {
            return 1;
        }
                    
        if ($this->getRow() === 3 && $this->getCol() === 1) {
            return 1;
        }
        
        return 0;
    }
    
    /**
     * @return int
     */
    public function getFoodReward() {
        if ($this->getRow() === 4 && $this->getCol() === 2) {
            return 1;
        }        
        return 0;        
    }    
}
