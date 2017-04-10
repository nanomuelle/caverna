<?php

namespace Caverna\CoreBundle\Entity\CaveSpace;
use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace;

/**
 * @ORM\Entity;
 */
class TunnelCaveSpace extends BaseCaveSpace {    
    public function __toString() {
        $f2 = chr(177);
        $ul = chr(218); // ┌
        $bl = chr(192); // └    
        $ur = chr(191); // ┐
        $br = chr(217); // ┘
//        return
//            "<bg=blue;fg=cyan>$ur$f2$ul</>\n".
//            "<bg=blue;fg=cyan>$f2$f2$f2</>\n".
//            "<bg=blue;fg=cyan>$br$f2$bl</>"
//        ;  
        return
            "<bg=blue;fg=cyan>$f2 $f2</>\n".
            "<bg=blue;fg=cyan>   </>\n".
            "<bg=blue;fg=cyan>$f2 $f2</>"
        ;  
    }
}
