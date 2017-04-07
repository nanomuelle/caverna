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
    
    public function spaceForDwarfs() {
        return self::SPACE_FOR_DWARFS;
    }      
    
    public function __toString() {
        return 'H';
    }
}
