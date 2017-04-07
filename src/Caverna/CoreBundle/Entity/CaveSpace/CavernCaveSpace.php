<?php

namespace Caverna\CoreBundle\Entity\CaveSpace;
use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace;

/**
 * @ORM\Entity;
 */
class CavernCaveSpace extends BaseCaveSpace {
    public function __toString() {
        return '<bg=blue> </>';// C;
    }
}
