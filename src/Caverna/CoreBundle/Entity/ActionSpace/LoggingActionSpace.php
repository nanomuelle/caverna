<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * @ORM\Entity;
 */
class LoggingActionSpace extends ActionSpace {
    const KEY = 'Logging';
    
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
        return 'Madera: 3(3)';
    }
    
    public function getState() {
        return 'Madera: ' . $this->getWood();
    }        
    
    public function __construct() {
        parent::__construct();
        $this->setName('Logging');
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
