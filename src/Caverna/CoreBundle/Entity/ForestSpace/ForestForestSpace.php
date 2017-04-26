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
                $rightForestSpace = $this->getPlayer()->getForestSpaceByRowCol($this->getRow(), $this->getCol() + 1);
                
                // me and rightForestSpace are ForestForestSpace
                if (!$this instanceof ForestForestSpace || !$rightForestSpace instanceof ForestForestSpace) {
                    return false;
                }
                
                return parent::acceptsTile(TileFactory::TILE_F) || $rightForestSpace->acceptsTile(TileFactory::TILE_M);
                
            case TileFactory::TILE_MF_HORIZONTAL:
                $rightForestSpace = $this->getPlayer()->getForestSpaceByRowCol($this->getRow(), $this->getCol() + 1);
                
                // me and rightForestSpace are ForestForestSpace
                if (!$this instanceof ForestForestSpace || !$rightForestSpace instanceof ForestForestSpace) {
                    return false;
                }
                
                return parent::acceptsTile(TileFactory::TILE_M) || $rightForestSpace->acceptsTile(TileFactory::TILE_F);
            
            case TileFactory::TILE_FM_VERTICAL:
                $bottomForestSpace = $this->getPlayer()->getForestSpaceByRowCol($this->getRow() + 1, $this->getCol());
                
                // me and bottomForestSpace are ForestForestSpace
                if (!$this instanceof ForestForestSpace || !$bottomForestSpace instanceof ForestForestSpace) {
                    return false;
                }
                
                if ($bottomForestSpace->isExternal()) {
                    return false;
                }                

                return parent::acceptsTile(TileFactory::TILE_F) || $bottomForestSpace->acceptsTile(TileFactory::TILE_M);
                
            case TileFactory::TILE_MF_VERTICAL:
                $bottomForestSpace = $this->getPlayer()->getForestSpaceByRowCol($this->getRow() + 1, $this->getCol());
                
                // me and bottomForestSpace are ForestForestSpace
                if (!$this instanceof ForestForestSpace || !$bottomForestSpace instanceof ForestForestSpace) {
                    return false;
                }
                
                if ($bottomForestSpace->isExternal()) {
                    return false;
                }
                
                return parent::acceptsTile(TileFactory::TILE_M) || $bottomForestSpace->acceptsTile(TileFactory::TILE_F);
            
            default:
                return false;
        }
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
