<?php

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
        return 'Comida: -2';
    }
    
    public function getState() {
        return 'Comida: -2';
    }
            
    public function __construct() {
        parent::__construct();
        $this->setName('Imitation');
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
