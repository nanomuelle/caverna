<?php

namespace AppBundle\Renderer;

use Caverna\CoreBundle\Entity\CaveSpace\TunnelCaveSpace;

class TunnelCaveSpaceRenderer {
    /**
     * @return string
     */
    public static function render(TunnelCaveSpace $caveSpace, $key = '') {
        $f2 = chr(177);
//        $ul = chr(218); // ┌
//        $bl = chr(192); // └    
//        $ur = chr(191); // ┐
//        $br = chr(217); // ┘
//        return
//            "<bg=blue;fg=cyan>$ur$f2$ul</>\n".
//            "<bg=blue;fg=cyan>$f2$f2$f2</>\n".
//            "<bg=blue;fg=cyan>$br$f2$bl</>"
//        ;  
        if ($key === '') {
            return
                "<bg=blue;fg=cyan>$f2 $f2</>\n".
                "<bg=blue;fg=cyan>   </>\n".
                "<bg=blue;fg=cyan>$f2 $f2</>"
            ;  
        }
        return
            "<bg=blue;fg=cyan>$f2 $f2</>\n".
            "<bg=blue;fg=cyan> </><bg=black;fg=white>" . $key . "</><bg=blue;fg=cyan> </>\n".
            "<bg=blue;fg=cyan>$f2 $f2</>"
        ;                 
    }
}
