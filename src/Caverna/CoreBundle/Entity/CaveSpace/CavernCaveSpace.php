<?php

namespace Caverna\CoreBundle\Entity\CaveSpace;
use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace;

/**
 * @ORM\Entity;
 */
class CavernCaveSpace extends BaseCaveSpace {
    public function acceptsCavernTunnelTile() {
        return false;
    }
    
//    public function __toString() {
//        $f2 = chr(177);
//        $ul = chr(218); // ┌
//        $bl = chr(192); // └    
//        $ur = chr(191); // ┐
//        $br = chr(217); // ┘
//        return
//            "<bg=blue;fg=cyan>$ul $ur</>\n".
//            "<bg=blue;fg=white>   </>\n".
//            "<bg=blue;fg=cyan>$bl $br</>"
//        ;  
//    }
}
