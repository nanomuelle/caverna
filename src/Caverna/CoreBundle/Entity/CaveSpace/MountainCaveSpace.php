<?php

namespace Caverna\CoreBundle\Entity\CaveSpace;
use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace;

/**
 * @ORM\Entity;
 */
class MountainCaveSpace extends BaseCaveSpace {

    public function getFoodReward() {
        if ($this->getRow() === 1 && $this->getCol() === 2) {
            return 2;
        }
        
        if ($this->getRow() === 3 && $this->getCol() === 1) {
            return 1;
        }
        
        return 0;
    }    
    
    public function isExternal() {
        if ($this->getRow() === 0 || $this->getRow() === 4 || $this->getCol() === 3) {
            return true;
        }
        
        return false;
    }
    
    public function __toString() {
        if ($this->isExternal()) {
            return '-';
        }
        
        if ($this->getFoodReward() > 0) {
            return '' . $this->getFoodReward();
        }
        
        return 'o';
    }
    
    
}
