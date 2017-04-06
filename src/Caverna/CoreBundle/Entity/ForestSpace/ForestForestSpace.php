<?php

namespace Caverna\CoreBundle\Entity\ForestSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ForestSpace\BaseForestSpace;

/**
 * @ORM\Entity;
 */
class ForestForestSpace extends BaseForestSpace {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    public function isExternal() {
        if ($this->getRow() === 0 || $this->getRow() === 4 || $this->getCol() === 0) {
            return true;
        }
        
        return false;
    }
    
    /**
     * @return int
     */
    public function getBoarReward() {
        if ($this->getRow() === 1 && $this->getCol() === 3) {
            return 1;
        }
                    
        if ($this->getRow() === 2 && $this->getCol() === 1) {
            return 1;
        }
        
        return 0;
    }
    
    /**
     * @return int
     */
    public function getFoodReward() {
        if ($this->getRow() === 3 && $this->getCol() === 2) {
            return 1;
        }        
        return 0;        
    }    
    
    public function __toString() {
        if ($this->isExternal()) {
            return '-';
        }
        
        if ($this->getFoodReward() > 0) {
            return '1';
        }
        
        if ($this->getBoarReward() > 0) {
            return 'b';
        }
        
        return '.';
    }
    
}
