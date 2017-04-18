<?php

namespace AppBundle\Renderer;

use Caverna\CoreBundle\Entity\CaveSpace\CavernCaveSpace;

class CavernCaveSpaceRenderer {
    /**
     * @return string
     */
    public static function render(CavernCaveSpace $cavern, $key = '') {
//        $f2 = chr(177);
        $ul = chr(218); // ┌
        $bl = chr(192); // └    
        $ur = chr(191); // ┐
        $br = chr(217); // ┘
        
        if ($key === '') {
            return
                "<bg=blue;fg=cyan>$ul $ur</>\n".
                "<bg=blue;fg=white>   </>\n".
                "<bg=blue;fg=cyan>$bl $br</>"
            ;         
        }
        return
            "<bg=blue;fg=cyan>$ul $ur</>\n".
            "<bg=blue;fg=white> </><bg=black;fg=white>" . $key . "</><bg=blue;fg=white> </>\n".
            "<bg=blue;fg=cyan>$bl $br</>"
        ;                 
    }
}
