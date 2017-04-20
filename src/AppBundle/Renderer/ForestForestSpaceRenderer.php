<?php

namespace AppBundle\Renderer;

use AppBundle\Renderer\SpaceRenderer as SR;
use Caverna\CoreBundle\Entity\ForestSpace\ForestForestSpace;

class ForestForestSpaceRenderer {
    /**
     * @return string
     */
    public static function render(ForestForestSpace $forest, $key = '') {
        if ($forest->isExternal()) {
            return SR::render(
                SR::EXTERNAL_FOREST, SR::EXTERNAL_FOREST, SR::EXTERNAL_FOREST,
                SR::EXTERNAL_FOREST, SR::EXTERNAL_FOREST, SR::EXTERNAL_FOREST,
                SR::EXTERNAL_FOREST, SR::EXTERNAL_FOREST, SR::EXTERNAL_FOREST,
                $key);            
        }
        
        // food reward
        if ($forest->getFoodReward() === 1) {
            return SR::render(
                SR::FOREST, SR::FOREST, SR::FOREST,
                SR::FOREST, SR::RIVER, SR::FOREST,
                SR::FOREST, SR::FOOD_PLUS, SR::FOOD_1,
                $key);
        }
       
        // wild boar reward
        if ($forest->getBoarReward() === 1) {
            return SR::render(
                SR::FOREST, SR::FOREST, SR::FOREST,
                SR::BOAR_REWARD, SR::EXTERNAL_FOREST, SR::FOREST,
                SR::FOREST, SR::FOREST, SR::FOREST,
                $key);            
        }
        
        // initial forest space
        if ($forest->getRow() === 4 && $forest->getCol() === 3) {            
            return SR::render(
                SR::FOREST, SR::FOREST, SR::INITIAL_FOREST,
                SR::FOREST, SR::EXTERNAL_FOREST, SR::INITIAL_FOREST,
                SR::FOREST, SR::FOREST, SR::INITIAL_FOREST,
                $key);            
        }
        
        // empty forest space
        return SR::render(
            SR::FOREST, SR::FOREST, SR::FOREST,
            SR::FOREST, SR::EXTERNAL_FOREST, SR::FOREST,
            SR::FOREST, SR::FOREST, SR::FOREST,
            $key);            
    }
}
