<?php

namespace AppBundle\Renderer;

use AppBundle\Renderer\SpaceRenderer as SR;
use Caverna\CoreBundle\Entity\ForestSpace\FieldForestSpace;

class FieldForestSpaceRenderer {
    /**
     * @return string
     */
    public static function render(FieldForestSpace $forestSpace, $key = '') {
        return SR::render(
            SR::FIELD, SR::FIELD, SR::FIELD, 
            SR::FIELD, SR::FIELD, SR::FIELD, 
            SR::FIELD, SR::FIELD, SR::FIELD, 
            $key);        
    }
}
