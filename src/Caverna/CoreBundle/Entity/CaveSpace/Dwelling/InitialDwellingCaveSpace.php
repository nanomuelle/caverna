<?php

namespace Caverna\CoreBundle\Entity\CaveSpace\Dwelling;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace;

use Caverna\CoreBundle\GameEngine\Dwelling\SpaceForDwarfsInterface;

/**
 * @ORM\Entity;
 */
class InitialDwellingCaveSpace extends BaseCaveSpace implements SpaceForDwarfsInterface {
    const SPACE_FOR_DWARFS = 2;
    
    public function acceptsCavernTunnelTile() {
        return false;
    }
    
    public function spaceForDwarfs() {
        return self::SPACE_FOR_DWARFS;
    }      
    
    public function __toString() {
//        return "<fg=white;bg=blue;options=bold>\xF0\x9F\x8F\xA0</>"; //'H';
//        return "<fg=white;bg=blue;options=bold>H</>"; //'H';
        $f2 = chr(177);
        return
            "<bg=yellow;fg=black>  0</>\n".
            "<bg=white;fg=black> H </>\n".
            "<bg=white;fg=black>   </>"
        ;  
    }
}
