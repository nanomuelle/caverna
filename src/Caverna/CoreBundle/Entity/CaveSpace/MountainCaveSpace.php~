<?php

namespace Caverna\CoreBundle\Entity\CaveSpace;
use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace;

/**
 * @ORM\Entity;
 */
class MountainCaveSpace extends BaseCaveSpace {

    public function getFood() {
        if ($this->getRow() === 1 && $this->getCol() === 3) {
            return 2;
        }
        
        if ($this->getRow() === 0 && $this->getCol() === 1) {
            return 1;
        }
        
        return 0;
    }    
}
