<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\ImitationActionSpace;
use Caverna\CoreBundle\Entity\Player;

/**
 * Imitation (3-7 players): Use an Action space occupied by one of your 
 * opponents (see page 22 of the rule book). This may cost an amount of Food 
 * depending on the number of players. The following table summarizes these 
 * costs. In games with 5 or more players, there are multiple “Imitation” Action 
 * spaces with different costs. (The “Imitation” Action space can be found on 
 * various game boards.) Special case: You may not imitate an Imitation action
 * that is occupied by your opponent only to imitate another Action space that 
 * is occupied by one of your Dwarfs.
 * 
 * Number of player: 3 | 4 | 5     | 6     | 7
 * Food cost:        4 | 2 | 2 or 4| 1 or 2| 0, 1 or 2    
 */
class Imitation {
    public static function execute(ImitationActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();

        $player->addFood(-ImitationActionSpace::FOOD_COST);
        
        $imitatedActionSpace = $actionSpace->getImitatedActionSpace();
        
        $actionClass = '\\Caverna\CoreBundle\\GameEngine\\Action\\' . $imitatedActionSpace->getKey();
        $actionClass::execute($imitatedActionSpace, $player);        
    }
}