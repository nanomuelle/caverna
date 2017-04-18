<?php

namespace AppBundle\Renderer;

use Caverna\CoreBundle\Entity\CaveSpace\MountainCaveSpace;

class MountainCaveSpaceRenderer {
    /**
     * @return string
     */
    public static function render(MountainCaveSpace $caveSpace, $key = '') {
//        $f1 = chr(176);
        $f2 = chr(177);
//        $f3 = chr(178);
        
        if ($caveSpace->isExternal()) {
            if ($key === '') {
                return
                    "<bg=green;fg=black>$f2$f2$f2</>\n".
                    "<bg=green;fg=black>$f2$f2$f2</>\n".
                    "<bg=green;fg=black>$f2$f2$f2</>"
                ;                 
            }
            return
                "<bg=green;fg=black>$f2$f2$f2</>\n".
                "<bg=green;fg=black>$f2<bg=black;fg=white>$key</>$f2</>\n".
                "<bg=green;fg=black>$f2$f2$f2</>"
            ;                 
        }
        
        if ($caveSpace->getFoodReward() === 1) {
            if ($key === '') {
                return
                    "<bg=cyan;fg=black>$f2$f2$f2</>\n".
                    "<bg=cyan;fg=black>$f2$f2$f2</>\n".
                    "<bg=cyan;fg=black>$f2</><bg=cyan;fg=black>+1</>"
                ;  
            }
            return
                "<bg=cyan;fg=black>$f2$f2$f2</>\n".
                "<bg=green;fg=black>$f2<bg=black;fg=white>$key</>$f2</>\n".
                "<bg=cyan;fg=black>$f2</><bg=cyan;fg=black>+1</>"
            ;  
        }
        
        if ($caveSpace->getFoodReward() === 2) {
            if ($key === '') {
                return
                    "<bg=cyan;fg=black>$f2</><bg=cyan;fg=black>+2</>\n".
                    "<bg=cyan;fg=black>$f2</><bg=cyan>  </>\n".
                    "<bg=cyan;fg=black>$f2$f2$f2</>"
                ;              
            }
            return
                "<bg=cyan;fg=black>$f2</><bg=cyan;fg=black>+2</>\n".
                "<bg=cyan;fg=black>$f2</><bg=black;fg=white>$key</><bg=cyan> </>\n".
                "<bg=cyan;fg=black>$f2$f2$f2</>"
            ;              
        }
        
        return
            "<bg=cyan;fg=black>$f2$f2$f2</>\n".
            "<bg=cyan;fg=black>$f2<bg=black;fg=white>$key$f2</>\n".
            "<bg=cyan;fg=black>$f2$f2$f2</>"
        ;            
    }
}
