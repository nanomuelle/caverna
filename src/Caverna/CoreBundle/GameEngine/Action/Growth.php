<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\GrowthActionSpace;
use Caverna\CoreBundle\Entity\Player;

/**
 * Growth (4-7 players): Take 1 Wood, 1 Stone, 1 Ore, 1 Food and 2 Gold from the
 *  general supply. Alternatively, carry out a Family growth action.
 */
class Growth {
    const TAKE_RESOURCES = 'TAKE_RESOURCES';
    const FAMILY_GROWTH = 'FAMILY_GROWTH';
    
    public static function execute(GrowthActionSpace $actionSpace, Player $player, $options) {        
//        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();        
        if ($options === self::TAKE_RESOURCES) {
            $player->addFood($actionSpace->getFood());
            $player->addWood($actionSpace->getWood());
            $player->addStone($actionSpace->getStone());
            $player->addOre($actionSpace->getOre());
            $player->addVp($actionSpace->getVp());
        } else {
            // TODO: Family Growth
            // ...
        }
    }    
}