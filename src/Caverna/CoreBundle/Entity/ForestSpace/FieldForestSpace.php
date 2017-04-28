<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Caverna\CoreBundle\Entity\ForestSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ForestSpace\BaseForestSpace;

/**
 * @ORM\Entity;
 */
class FieldForestSpace extends BaseForestSpace 
{
    /**
     *
     * @ORM\Column(type="smallint")
     */
    private $grain;
    
    /**
     * @ORM\Column(type="smallint")
     */
    private $vegetable;
    
    public function acceptsTile($tileType) {
        return false;
    } 
    
    public function sowGrain() {
        $this->setGrain(3);
        $this->getPlayer()->addGrain(-1);
    }
    
    public function sowVegetable() {
        $this->setVegetable(3);
        $this->getPlayer()->addVegetable(-1);
    }
    
    public function isEmpty() {
        return $this->getGrain() + $this->getVegetable() === 0;
    }
}
