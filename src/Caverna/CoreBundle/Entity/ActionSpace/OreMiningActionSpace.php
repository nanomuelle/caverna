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
    
    const INITIAL_ORE = 3;
    const REPLENISH_ORE = 2;
    
    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {
        return self::DESCRIPTION;
    }
    
    public function getState() {        
        return 'Mineral: ' . $this->getOre();
    }        
    
    public function getOre() {
        return self::ORE;
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Ore Mining');
        $this->ore = 0;
    }
}
