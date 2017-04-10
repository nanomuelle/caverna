<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

use Caverna\CoreBundle\Entity\CaveSpace\CavernCaveSpace;
use Caverna\CoreBundle\Entity\CaveSpace\TunnelCaveSpace;

/**
 * @ORM\Entity;
 */
class DriftMiningActionSpace extends ActionSpace {
    const KEY = 'DriftMining';
    const DESCRIPTION_1_TO_3 = 'Piedra 1(1)';
    const DESCRIPTION_4_TO_7 = 'Piedra 2(2)';
    
    /**
     * @ORM\Column(type="integer")
     */
    private $stone;
    
    /**
     * @var CavernCaveSpace
     */
    private $cavern;
    
    /**
     * @var TunnelCaveSpace
     */
    private $tunnel;
    
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
    
    /**
     * @return CavernCaveSpace
     */
    public function getCavernCaveSpace() {
        return $this->cavernCaveSpace;
    }
    public function setCavernCaveSpace(CavernCaveSpace $cavernCaveSpace) {
        $this->cavernCaveSpace = $cavernCaveSpace;
        return $this;
    }
    
    /**
     * @return TunnelCaveSpace
     */
    public function getTunnelCaveSpace() {
        return $this->tunnelCaveSpace;
    }
    public function setTunnelCaveSpace(TunnelCaveSpace $tunnelCaveSpace) {
        $this->tunnelCaveSpace = $tunnelCaveSpace;
        return $this;
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Drift Mining');
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
