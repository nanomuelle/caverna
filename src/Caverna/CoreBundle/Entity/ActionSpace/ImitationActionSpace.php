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
    private $imitatedActionSpace;
    
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

    public function __toString() {
        $imitated = $this->getImitatedActionSpace() === null ? '' : ' (' . $this->getImitatedActionSpace() . ')';
        return parent::__toString() . $imitated;
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Imitation');
    }

    /**
     * Set imitatedActionSpace
     *
     * @param \Caverna\CoreBundle\Entity\ActionSpace\ActionSpace $imitatedActionSpace
     *
     * @return ImitationActionSpace
     */
    public function setImitatedActionSpace(\Caverna\CoreBundle\Entity\ActionSpace\ActionSpace $imitatedActionSpace = null)
    {
        $this->imitatedActionSpace = $imitatedActionSpace;

        return $this;
    }

    /**
     * Get imitatedActionSpace
     *
     * @return \Caverna\CoreBundle\Entity\ActionSpace\ActionSpace
     */
    public function getImitatedActionSpace()
    {
        return $this->imitatedActionSpace;
    }
}
