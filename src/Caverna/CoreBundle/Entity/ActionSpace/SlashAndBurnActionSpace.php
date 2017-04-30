<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;
use Caverna\CoreBundle\Entity\ForestSpace\FieldForestSpace;

/**
 * Slash-and-burn: Place a Meadow/Field twin tile on 2 adjacent Forest spaces 
 * of your Home board that are not covered by any tiles. (See “Clearing” for 
 * further details.) Afterwards, you may carry out a Sow action to sow up 
 * to 2 new Grain and/or up to 2 new Vegetable fields (as usual).
 *
 * @ORM\Entity;
 */
class SlashAndBurnActionSpace extends ActionSpace
{
    const KEY = 'SlashAndBurn';

    private $fieldForestSpacesForGrain;
    private $fieldForestSpacesForVegetable;

    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {
        return '[MF Tile] & Sow';
    }
     
    public function getState() {
        return '[MF Tile] & Sow';
    }
    
    public function getFieldForestSpacesForGrain() {
        return $this->fieldForestSpacesForGrain;
    }
    
    public function addFieldForestSpacesForGrain(FieldForestSpace $field) {
        $this->fieldForestSpacesForGrain[] = $field;
    }
    
    public function getFieldForestSpacesForVegetable() {
        return $this->fieldForestSpacesForVegetable;
    }
    
    public function addFieldForestSpacesForVegetable(FieldForestSpace $field) {
        $this->fieldForestSpacesForVegetable[] = $field;
    }

    public function __construct() {
        parent::__construct();
        $this->setName('Slash and burn');
        $this->fieldForestSpacesForGrain = array();
        $this->fieldForestSpacesForVegetable = array();
    }
}
