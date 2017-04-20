<?php

namespace AppBundle\Renderer;

use AppBundle\Renderer\SpaceRenderer as SR;
use Caverna\CoreBundle\Entity\CaveSpace\TunnelCaveSpace;

class TunnelCaveSpaceRenderer {
    /**
     * @return string
     */
    public static function render(TunnelCaveSpace $caveSpace, $key = '') {
        return SR::render(
            SR::TUNNEL_CORNER, SR::TUNNEL, SR::TUNNEL_CORNER,
            SR::TUNNEL, SR::TUNNEL, SR::TUNNEL,
            SR::TUNNEL_CORNER, SR::TUNNEL, SR::TUNNEL_CORNER,
            $key);        
    }
}
