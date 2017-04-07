<?php

namespace Caverna\CoreBundle\Entity\CaveSpace\Dwelling;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\CaveSpace\Dwelling\DwellingCaveSpace;
use Caverna\CoreBundle\GameEngine\Dwelling\SpaceForDwarfsInterface;
/**
 * @ORM\Entity;
 */
class SimpleDwellingCaveSpace extends DwellingCaveSpace implements SpaceForDwarfsInterface {
    const SPACE_FOR_DWARFS = 1;
    
    public function spaceForDwarfs() {
        return self::SPACE_FOR_DWARFS;
    }
}
