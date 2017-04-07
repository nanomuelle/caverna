<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * @ORM\Entity;
 */
class ExcavationActionSpace extends ActionSpace {
    const KEY = 'Excavation';
    const DESCRIPTION_1_TO_3 = 'Piedra 1(1)';
    const DESCRIPTION_4_TO_7 = 'Piedra 2(1)';
    
    /**
     * @ORM\Column(type="integer")
     */
    private $stone;
    
    public function getKey() {
        return self::KEY;
    }
    
    public function addStone($amount) {
        $this->stone += $amount;
    }
    
    public function getDescription() {
        if ($this->getGame()->getNumPlayers() < 4) {
            return self::DESCRIPTION_1_TO_3;
        }
        return self::DESCRIPTION_4_TO_7;
    }
    
    public function getState() {
        return 'Piedra: ' . $this->getStone();
    }
        
    public function __construct() {
        parent::__construct();
        $this->setName('Excavation');
        $this->stone = 0;
    }

    /**
     * Set stone
     *
     * @param integer $stone
     *
     * @return DriftMiningActionSpace
     */
    public function setStone($stone)
    {
        $this->stone = $stone;

        return $this;
    }

    /**
     * Get stone
     *
     * @return integer
     */
    public function getStone()
    {
        return $this->stone;
    }
}
