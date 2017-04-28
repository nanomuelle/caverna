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

    /**
     * Set grain
     *
     * @param integer $grain
     *
     * @return FieldForestSpace
     */
    public function setGrain($grain)
    {
        $this->grain = $grain;

        return $this;
    }

    /**
     * Get grain
     *
     * @return integer
     */
    public function getGrain()
    {
        return $this->grain;
    }

    /**
     * Set vegetable
     *
     * @param integer $vegetable
     *
     * @return FieldForestSpace
     */
    public function setVegetable($vegetable)
    {
        $this->vegetable = $vegetable;

        return $this;
    }

    /**
     * Get vegetable
     *
     * @return integer
     */
    public function getVegetable()
    {
        return $this->vegetable;
    }
}
