<?php

namespace Caverna\CoreBundle\Entity\CaveSpace;
use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace;

/**
 * @ORM\Entity;
 */
class MountainCaveSpace extends BaseCaveSpace {
    public function acceptsCavernTunnelTile() {
        return !$this->isExternal();
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
    
//    public function __toString() {
////        if ($this->isExternal()) {
////            return "<fg=cyan>\xF0\x9F\x8C\x84</>";
////        }
////        
////        if ($this->getFoodReward() === 1) {
////            return "<fg=yellow>\xF0\x9F\x8D\xB5</>"; // '1';
////        }
////        
////        if ($this->getFoodReward() === 2) {
////            return "<fg=yellow>\xF0\x9F\x8D\x92</>"; // '1';
////        }
////        
////        return "<fg=cyan;options=bold>\xF0\x9F\x97\xBB</>"; //'o';
//        
////        if ($this->getRow() === 0 && $this->getCol() === 3) {
////            return chr(191);
////        }
////
////        if ($this->getRow() === 4 && $this->getCol() === 3) {
////            return chr(217); 
////        }
////
////        if ($this->getRow() === 0 || $this->getRow() === 4) {
////            return chr(196). chr(196). chr(196); // ─
////        }
////
////        if ($this->getCol() === 3) {
////            return chr(179); // │
////        }
//        $f1 = chr(176);
//        $f2 = chr(177);
//        $f3 = chr(178);
//        if ($this->isExternal()) {
//            return
//                "<bg=green;fg=black>$f2$f2$f2</>\n".
//                "<bg=green;fg=black>$f2$f2$f2</>\n".
//                "<bg=green;fg=black>$f2$f2$f2</>"
//            ;                            
//        }
//        
//        if ($this->getFoodReward() === 1) {
//            return
//                "<bg=cyan;fg=black>$f2$f2$f2</>\n".
//                "<bg=cyan;fg=black>$f2</><bg=cyan;fg=black>+1</>\n".
//                "<bg=cyan;fg=black>$f2$f2$f2</>"
//            ;  
//        }
//        
//        if ($this->getFoodReward() === 2) {
////            return "<fg=yellow>2</>"; // '1';
//            return
//                "<bg=cyan;fg=black>$f2</><bg=cyan>  </>\n".
//                "<bg=cyan;fg=black>$f2</><bg=cyan;fg=black>+2</>\n".
//                "<bg=cyan;fg=black>$f2$f2$f2</>"
//            ;              
//        }
//        
////        return "<fg=cyan;options=bold>m</>"; //'o'; 
//        return
//            "<bg=cyan;fg=black>$f2$f2$f2</>\n".
//            "<bg=cyan;fg=black>$f2$f2$f2</>\n".
//            "<bg=cyan;fg=black>$f2$f2$f2</>"
//        ;            
//    }
    
    
}
