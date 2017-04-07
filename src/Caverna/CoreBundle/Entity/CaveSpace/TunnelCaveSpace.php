<?php

namespace Caverna\CoreBundle\Entity\CaveSpace;
use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace;

/**
 * @ORM\Entity;
 */
class TunnelCaveSpace extends BaseCaveSpace {    
    public function __toString() {
        return '<bg=blue;fg=white;options=bold>+</>';// C;
    }
}
