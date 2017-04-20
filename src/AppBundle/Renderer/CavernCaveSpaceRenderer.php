<?php

namespace AppBundle\Renderer;

use AppBundle\Renderer\SpaceRenderer as SR;
use Caverna\CoreBundle\Entity\CaveSpace\CavernCaveSpace;

class CavernCaveSpaceRenderer {
    /**
     * @return string
     */
    public static function render(CavernCaveSpace $cavern, $key = '') {
        return SR::render(
            SR::CAVERN_UPPER_LEFT, SR::CAVERN, SR::CAVERN_UPPER_RIGHT,
            SR::CAVERN, SR::CAVERN, SR::CAVERN,
            SR::CAVERN_BOTTOM_LEFT, SR::CAVERN, SR::CAVERN_BOTTOM_RIGHT,
            $key);          
    }
}
