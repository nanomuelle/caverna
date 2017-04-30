<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\RubyMiningActionSpace;
use Caverna\CoreBundle\Entity\Player;

/**
 * Ruby mining: Take all the Rubies that have accumulated on this Action space. 
 * (Every round, 1 Ruby will be added to this Action space.) Take one more Ruby 
 * from the general supply if you have at least one Ruby mine. (In the first two 
 * rounds of a 2-player game, no Rubies will be added to this Action space.)
 *
 * @author marte
 */
class RubyMining {
    public static function execute(RubyMiningActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();

        $player->addRuby($actionSpace->getRuby());
        $actionSpace->setRuby(0);        
    }    
}
