<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;
use Caverna\CoreBundle\Entity\Player;

/**
 * @ORM\Entity;
 */
class ImitationActionSpace extends ActionSpace {
    const KEY = 'Imitation';
    
    const FOOD_COST = 2;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="\Caverna\CoreBundle\Entity\ActionSpace\ActionSpace")
     */
    private $actionSpace;
    
    public function isImitableForPlayer(Player $player) {
        return false;
    }
    
    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {
        return "Comida: -2\n";
    }
    
    public function getState() {
        return "Comida: -2\n";
    }
            
    public function __toString() {        
        return parent::__toString() . ' (-' . self::FOOD_COST . 'F)';
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Imitation');
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
     * Set actionSpace
     *
     * @param \Caverna\CoreBundle\Entity\ActionSpace\ActionSpace $actionSpace
     *
     * @return ImitationActionSpace
     */
    public function setActionSpace(\Caverna\CoreBundle\Entity\ActionSpace\ActionSpace $actionSpace = null)
    {
        $this->actionSpace = $actionSpace;

        return $this;
    }

    /**
     * Get actionSpace
     *
     * @return \Caverna\CoreBundle\Entity\ActionSpace\ActionSpace
     */
    public function getActionSpace()
    {
        return $this->actionSpace;
    }
}
