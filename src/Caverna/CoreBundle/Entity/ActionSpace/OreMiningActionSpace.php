<?php
namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * Ore mining: Take all the Ore that has accumulated on this Action space. (In
 * games with 1 to 3 players, 1 Ore will be added to this Action space every 
 * round unless it is empty. Then 2 Ore will be added to it instead. In games 
 * with 4 to 7 players, 2 Ore will be added to it every round unless it is
 * empty. Then 3 Ore will be added to it instead.) Additionally, you may 
 * take 2 Ore from the general supply for each Ore mine you have.
 * 
 * @ORM\Entity;
 */
class OreMiningActionSpace extends ActionSpace {
    const KEY = 'OreMining';
    const DESCRIPTION = 'Mineral: 3(2)';
    const INITIAL_ORE = 3;
    const REPLENISH_ORE = 2;
    
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

    public static function replenish() {
        if ($this->getOre() === 0) {
            $this->setOre(self::INITIAL_ORE);
        } else {
            $this->addOre(self::REPLENISH_ORE);
        }
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
