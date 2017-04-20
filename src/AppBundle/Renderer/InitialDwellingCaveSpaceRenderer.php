<?php

namespace AppBundle\Renderer;

use AppBundle\Renderer\SpaceRenderer as SR;
use Caverna\CoreBundle\Entity\CaveSpace\Dwelling\InitialDwellingCaveSpace;

class InitialDwellingCaveSpaceRenderer {
    /**
     * @return string
     */
    public static function render(InitialDwellingCaveSpace $caveSpace, $key = '') {
        return SR::render(
            SR::dwellingHeader('H'), SR::dwellingHeader(), SR::dwellingHeader('0'),
            SR::DWELLING, SR::DWELLING, SR::DWELLING,
            SR::DWELLING, SR::DWELLING, SR::DWELLING,
            $key);        
    }
}
