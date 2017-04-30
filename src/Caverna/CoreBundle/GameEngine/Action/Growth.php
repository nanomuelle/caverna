<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\GrowthActionSpace;
use Caverna\CoreBundle\Entity\Player;

/**
 * Growth (4-7 players): Take 1 Wood, 1 Stone, 1 Ore, 1 Food and 2 Gold from the
 *  general supply. Alternatively, carry out a Family growth action.
 */
class Growth {
    
    public static function execute(GrowthActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();
        
        $player->addFood($actionSpace->getFood());
        $player->addWood($actionSpace->getWood());
        $player->addStone($actionSpace->getStone());
        $player->addOre($actionSpace->getOre());
        $player->addVp($actionSpace->getVp());
    }    
}