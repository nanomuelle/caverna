<?php
namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * @ORM\Entity;
 */
class OreMiningActionSpace extends ActionSpace {
    const KEY = 'OreMining';
    const DESCRIPTION = 'Mineral: 3(2)';
    
    /**
     * @ORM\Column(type="integer")
     */
    private $ore;
    
    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {
        return self::DESCRIPTION;
    }
    
    public function getState() {        
        return 'Mineral: ' . $this->getOre();
    }        
    
    /**
     * 
     * @param int $amount
     */
    public function addOre($amount) {
        $this->ore += $amount;
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Ore Mining');
        $this->ore = 0;
    }

    /**
     * Set ore
     *
     * @param integer $ore
     *
     * @return OreMiningActionSpace
     */
    public function setOre($ore)
    {
        $this->ore = $ore;

        return $this;
    }

    /**
     * Get ore
     *
     * @return integer
     */
    public function getOre()
    {
        return $this->ore;
    }
}
