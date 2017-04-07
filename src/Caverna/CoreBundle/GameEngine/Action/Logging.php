<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\LoggingActionSpace;
use Caverna\CoreBundle\Entity\Player;

/**
 * Logging: Take all the Wood that has accumulated on this Action space. (In 
 * games with 1 to 3 players, 1 Wood will be added to this Action space every 
 * round unless it is empty. Then 3 Wood will be added to it instead. In games 
 * with 4 to 7 players, 3 Wood will be added to it every round regardless of 
 * whether it is empty or not.) 
 * Afterwards, you may undertake a Level 1 expedition if your Dwarf has 
 * a Weapon.
 */
class Logging {
    const INITIAL_WOOD = 3;
    const REPLENISH_WOOD_1_TO_3_PLAYERS = 1;
    const REPLENISH_WOOD_4_TO_7_PLAYERS = 3;
    
    public static function execute(LoggingActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();

        $player->addWood($actionSpace->getWood());
        $actionSpace->setWood(0);        
    }
    
    public static function replenish(LoggingActionSpace $actionSpace) {
        if ($actionSpace->getWood() > 0) {
            if ($actionSpace->getGame()->getNumPlayers() < 4) {
                $actionSpace->addWood(self::REPLENISH_WOOD_1_TO_3_PLAYERS);
            } else {
                $actionSpace->addWood(self::REPLENISH_WOOD_4_TO_7_PLAYERS);
            }
        } else {
            $actionSpace->setWood(self::INITIAL_WOOD);            
        }
    }
}