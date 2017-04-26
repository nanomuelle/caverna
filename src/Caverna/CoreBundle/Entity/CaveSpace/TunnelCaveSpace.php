<?php

namespace Caverna\CoreBundle\Entity\CaveSpace;
use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace;

/**
 * @ORM\Entity;
 */
class TunnelCaveSpace extends BaseCaveSpace 
{    
    public function acceptsTile($tileType) {
        return false;
    }       
}
