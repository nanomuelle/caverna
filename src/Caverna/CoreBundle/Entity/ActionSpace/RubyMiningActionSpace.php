<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * @ORM\Entity;
 */
class RubyMiningActionSpace extends ActionSpace {
    const KEY = 'RubyMining';
    
    /**
     * @ORM\Column(type="integer")
     */
    private $ruby;
    
    /**
     * 
     * @param integer $amount
     */
    public function addRuby($amount) {
        $this->ruby += $amount;
    }
    
    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {
        return 'Ruby: 1(1)';
    }
    
    public function getState() {
        return 'Ruby: ' . $this->getRuby();
    }        
    
    public function __construct() {
        parent::__construct();
        $this->setName('Ruby Mining');
        $this->ruby = 0;
    }

    /**
     * Set ruby
     *
     * @param integer $ruby
     *
     * @return RubyMiningActionSpace
     */
    public function setRuby($ruby)
    {
        $this->ruby = $ruby;

        return $this;
    }

    /**
     * Get ruby
     *
     * @return integer
     */
    public function getRuby()
    {
        return $this->ruby;
    }
}
