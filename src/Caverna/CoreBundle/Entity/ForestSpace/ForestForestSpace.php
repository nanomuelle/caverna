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
//            if ($this->getRow() === 0 && $this->getCol() === 0) {
//                return '+'; // chr(218); // ┌
//            }
//            
//            if ($this->getRow() === 4 && $this->getCol() === 0) {
//                return '+'; //chr(192); // └
//            }
//            
//            if ($this->getRow() === 0 || $this->getRow() === 4) {
//                return '-'; // chr(196); // ─
//            }
//            
//            if ($this->getCol() === 0) {
//                return '|'; // chr(179); // │
//            }

            return "<fg=green>\xF0\x9F\x8C\xB5</>"; //"\xF0\x9F\x8C\xB5";
            
        }
        
        if ($this->getFoodReward() > 0) {
            return "<fg=yellow>\xF0\x9F\x8D\xB5</>"; // '1';
        }
        
        if ($this->getBoarReward() > 0) {
            return "<fg=red;options=bold>\xF0\x9F\x90\xB7</>"; // 'b';
        }
        
        // initial forest space
        if ($this->getRow() === 3 && $this->getCol() === 3) {            
            return "<fg=white;options=bold>\xF0\x9F\x8C\xB2</>"; // '<';
        }
        
        return "<fg=green;options=bold>\xF0\x9F\x8C\xB2</>"; // chr(177); //'.';
    }
    
}
