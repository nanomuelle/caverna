<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;
use Caverna\CoreBundle\Entity\Player;

/**
 * Imitation (3-7 players): Use an Action space occupied by one of your 
 * opponents (see page 22 of the rule book). This may cost an amount of Food 
 * depending on the number of players. The following table summarizes these 
 * costs. In games with 5 or more players, there are multiple “Imitation” Action 
 * spaces with different costs. (The “Imitation” Action space can be found on 
 * various game boards.) Special case: You may not imitate an Imitation action
 * that is occupied by your opponent only to imitate another Action space that 
 * is occupied by one of your Dwarfs.
 * 
 * Number of player: 3 | 4 | 5     | 6     | 7
 * Food cost:        4 | 2 | 2 or 4| 1 or 2| 0, 1 or 2    
 * 
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
