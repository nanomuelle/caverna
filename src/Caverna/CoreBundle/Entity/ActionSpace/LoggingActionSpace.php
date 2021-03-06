<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * @ORM\Entity;
 */
class LoggingActionSpace extends ActionSpace {
    const KEY = 'Logging';
    
    const INITIAL_WOOD = 3;
    const REPLENISH_WOOD = 3;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $wood;
    
    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {
        return "Madera: 3(3)\n";
    }
    
    public function getState() {
        return 'Madera: ' . $this->getWood() . "\n";
    }        
    
    public function __toString() {        
        return parent::__toString() . ' (' . $this->getWood() . 'W)';
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Logging');
        $this->wood = 0;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set wood
     *
     * @param integer $wood
     *
     * @return LoggingActionSpace
     */
    public function setWood($wood)
    {
        $this->wood = $wood;

        return $this;
    }

    /**
     * Get wood
     *
     * @return integer
     */
    public function getWood()
    {
        return $this->wood;
    }
}
