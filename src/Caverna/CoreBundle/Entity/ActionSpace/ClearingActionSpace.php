<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * @ORM\Entity;
 */
class ClearingActionSpace extends ActionSpace {
    const KEY = 'Clearing';
    const DESCRIPTION_1_TO_3 = "Madera 1(1)";
    const DESCRIPTION_4_TO_7 = "Madera 2(2)";
    
    /**
     * @ORM\Column(type="integer")
     */
    private $wood;
    
    /**
     * 
     * @param integer $amount
     */
    public function addWood($amount) {
        $this->wood += $amount;
    }
    
    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {
        if ($this->getGame()->getNumPlayers() < 4) {
            return self::DESCRIPTION_1_TO_3;
        }
        
        return self::DESCRIPTION_4_TO_7;
    }
    
    public function getState() {
        return 'Madera: ' . $this->getWood();
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Clearing');
        $this->wood = 0;
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
