<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\OreMiningActionSpace;
use Caverna\CoreBundle\Entity\Player;

/**
 * Ore mining: Take all the Ore that has accumulated on this Action space. (In
 * games with 1 to 3 players, 1 Ore will be added to this Action space every 
 * round unless it is empty. Then 2 Ore will be added to it instead. In games 
 * with 4 to 7 players, 2 Ore will be added to it every round unless it is
 * empty. Then 3 Ore will be added to it instead.) Additionally, you may 
 * take 2 Ore from the general supply for each Ore mine you have.
 */
class OreMining 
{
        
    public static function execute(OreMiningActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();

        $player->addOre($actionSpace->getOre());
        $actionSpace->setOre(0);        
    }
}