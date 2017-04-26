<?php

namespace AppBundle\Renderer;

use AppBundle\Renderer\SpaceRenderer as SR;
use Caverna\CoreBundle\Entity\ForestSpace\MeadowForestSpace;

class MeadowForestSpaceRenderer 
{
    /**
     * @return string
     */
    public static function render(MeadowForestSpace $forestSpace, $key = '') {
        return SR::render(
            SR::MEADOW, SR::MEADOW, SR::MEADOW, 
            SR::MEADOW, SR::MEADOW, SR::MEADOW, 
            SR::MEADOW, SR::MEADOW, SR::MEADOW, 
            $key);        
    }
}
