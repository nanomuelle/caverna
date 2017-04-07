<?php

namespace Caverna\CoreBundle\Entity\ForestSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ForestSpace\BaseForestSpace;

/**
 * @ORM\Entity;
 */
class ForestForestSpace extends BaseForestSpace {
    
    public function isExternal() {
        if ($this->getRow() === 0 || $this->getRow() === 5 || $this->getCol() === 0) {
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
                    
        if ($this->getRow() === 3 && $this->getCol() === 1) {
            return 1;
        }
        
        return 0;
    }
    
    /**
     * @return int
     */
    public function getFoodReward() {
        if ($this->getRow() === 4 && $this->getCol() === 2) {
            return 1;
        }        
        return 0;        
    }    
    
    public function __toString() {
        $h = chr(196); // ─
        $f = chr(177); // ▒
        $v = chr(179); // │
        $ul = chr(218); // ┌
        $bl = chr(192); // └
        
        if ($this->isExternal()) {
                return
                    "<bg=green;fg=black>$f$f$f</>\n".
                    "<bg=green;fg=black>$f$f$f</>\n".
                    "<bg=green;fg=black>$f$f$f</>";
                
            if ($this->getRow() === 0 && $this->getCol() === 0) {
                return
                    "<bg=green;fg=black>$f$f$f</>\n".
                    "<bg=green;fg=black>$f$f$f</>\n".
                    "<bg=green;fg=black>$f$f$f</>"
//                    "<bg=green;fg=black>$f</><bg=green>$ul </>"
//                    "<bg=green;fg=black>$f</><bg=green>$v </>"
                ;
            }
            
            if ($this->getRow() === 5 && $this->getCol() === 0) {
              return
//                    "<bg=green;fg=black>$f</><bg=green>$v </>\n".
//                    "<bg=green;fg=black>$f</><bg=green>$bl </>\n".
                    "<bg=green;fg=black>$f$f$f</>\n".
                    "<bg=green;fg=black>$f$f$f</>\n".
                    "<bg=green;fg=black>$f$f$f</>"
                ;
            }
                       
            if ($this->getRow() === 0) {
                return
                    "<bg=green;fg=black>$f$f$f</>\n". 
                    "<bg=green;fg=black>$f$f$f</>\n". 
                    "<bg=green;fg=black>$f$f$f</>"
//                    "<bg=green>$h$h$h</>"
                ;  
            }

            if ($this->getRow() === 4) {
                return
                    "<bg=green>$h$h$h</>\n".
                    "<bg=green;fg=black>$f$f$f</>\n".
                    "<bg=green;fg=black>$f$f$f</>"
                ;  
            }
            
            if ($this->getCol() === 0) {
                return
                    "<bg=green;fg=black>$f<bg=green>$v </>\n".
                    "<bg=green;fg=black>$f<bg=green>$v </>\n".
                    "<bg=green;fg=black>$f<bg=green>$v </>"
                ;                  
                //return chr(179); // │
            }

            // Unicode => return "<fg=green>\xF0\x9F\x8C\xB5</>";
        }
        
        if ($this->getFoodReward() > 0) {
            // return "<fg=yellow>\xF0\x9F\x8D\xB5</>"; // Unicode
            return
                "<bg=green>   </>\n". 
                "<bg=cyan;fg=black>+1</><bg=green> </>\n".
                "<bg=green> <bg=cyan;fg=black> </> </>"
            ;
        }
       
        if ($this->getBoarReward() > 0) {
            // Unicode return "<fg=red;options=bold>\xF0\x9F\x90\xB7</>"; // 'b';
            return
                "<bg=green>   </>\n". 
                "<bg=green> <bg=white;fg=red>B</> </>\n".
                "<bg=green>   </>"
            ;
        }
        
        // initial forest space
        if ($this->getRow() === 4 && $this->getCol() === 3) {            
            // Unicode return "<fg=white;options=bold>\xF0\x9F\x8C\xB2</>"; // '<';
            return
                "<bg=green>   </>\n". 
                "<bg=green;fg=black> < </>\n".
                "<bg=green>   </>"
            ;     
        }
        
        // return "<fg=green;options=bold>\xF0\x9F\x8C\xB2</>"; // chr(177); //'.';
        //return "<fg=green;options=bold> f </>"; // chr(177); //'.';
        $f1 = chr(176);
        $f2 = chr(177);
        $f3 = chr(178);        
        return
            "<bg=green>   </>\n". 
            "<bg=green> <bg=green;fg=black>$f2</> </>\n".
            "<bg=green>   </>"
        ;        
    }
    
}
