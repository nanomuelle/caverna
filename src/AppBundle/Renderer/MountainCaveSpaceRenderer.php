<?php

namespace AppBundle\Renderer;

use AppBundle\Renderer\SpaceRenderer as SR;
use Caverna\CoreBundle\Entity\CaveSpace\MountainCaveSpace;

class MountainCaveSpaceRenderer {
    /**
     * @return string
     */
    public static function render(MountainCaveSpace $caveSpace, $key = '') {
        if ($caveSpace->isExternal()) {
            return SR::render(
                SR::EXTERNAL_MOUNTAIN, SR::EXTERNAL_MOUNTAIN, SR::EXTERNAL_MOUNTAIN,
                SR::EXTERNAL_MOUNTAIN, SR::EXTERNAL_MOUNTAIN, SR::EXTERNAL_MOUNTAIN,
                SR::EXTERNAL_MOUNTAIN, SR::EXTERNAL_MOUNTAIN, SR::EXTERNAL_MOUNTAIN,
                $key);
        }
        
        if ($caveSpace->getFoodReward() === 1) {
            return SR::render(
                SR::INTERNAL_MOUNTAIN, SR::INTERNAL_MOUNTAIN, SR::INTERNAL_MOUNTAIN,
                SR::INTERNAL_MOUNTAIN, SR::INTERNAL_MOUNTAIN, SR::INTERNAL_MOUNTAIN,
                SR::INTERNAL_MOUNTAIN, SR::FOOD_PLUS, SR::FOOD_1,
                $key);            
        }
        
        if ($caveSpace->getFoodReward() === 2) {
            return SR::render(
                SR::INTERNAL_MOUNTAIN, SR::INTERNAL_MOUNTAIN, SR::INTERNAL_MOUNTAIN,
                SR::INTERNAL_MOUNTAIN, SR::INTERNAL_MOUNTAIN, SR::INTERNAL_MOUNTAIN,
                SR::INTERNAL_MOUNTAIN, SR::FOOD_PLUS, SR::FOOD_2,
                $key);            
        }
        
        return SR::render(
            SR::INTERNAL_MOUNTAIN, SR::INTERNAL_MOUNTAIN, SR::INTERNAL_MOUNTAIN,
            SR::INTERNAL_MOUNTAIN, SR::INTERNAL_MOUNTAIN, SR::INTERNAL_MOUNTAIN,
            SR::INTERNAL_MOUNTAIN, SR::INTERNAL_MOUNTAIN, SR::INTERNAL_MOUNTAIN,
            $key);            
    }
}
