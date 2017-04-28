<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;
use Caverna\CoreBundle\Entity\ForestSpace\FieldForestSpace;

/**
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
