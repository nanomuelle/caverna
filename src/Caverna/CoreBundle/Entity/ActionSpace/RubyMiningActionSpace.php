<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * Ruby mining: Take all the Rubies that have accumulated on this Action space. 
 * (Every round, 1 Ruby will be added to this Action space.) Take one more Ruby 
 * from the general supply if you have at least one Ruby mine. (In the first two 
 * rounds of a 2-player game, no Rubies will be added to this Action space.)
 *
 * @ORM\Entity;
 */
class RubyMiningActionSpace extends ActionSpace {
    const KEY = 'RubyMining';
    const INITIAL_RUBY = 1;
    const REPLENISH_RUBY = 1;
    
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
    
    public function replenish() {
        if ($this->getGame()->getNumPlayers() === 2 &&
                $this->getGame()->getCurrentRound()->getNum() < 3) {
            return;
        }
        
        if ($this->getRuby() > 0) {
            $this->addRuby(self::REPLENISH_RUBY);
        } else {
            $this->setRuby(self::INITIAL_RUBY);
        }
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
