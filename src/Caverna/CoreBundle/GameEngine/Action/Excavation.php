<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\ExcavationActionSpace;
use Caverna\CoreBundle\Entity\Player;

/**
 * Excavation: Take all the Stone that has accumulated on this Action space. 
 * (1 Stone will be added to this Action space every round unless, in games 
 * with 4 to 7 players only, there is no Stone on it. Then 2 Stone will be 
 * added to it instead.) Additionally, you may place a Cavern/Tunnel or a 
 * Cavern/Cavern twin tile on 2 adjacent empty Mountain spaces of your Home 
 * board. You decide which side of the twin tile you want to use. If you place 
 * the twin tile on one of the underground water sources, you will immediately 
 * get 1 or 2 Food from the general supply. You have to place the twin tile 
 * adjacent to an already occupied Mountain space, i.e. you have to extend your 
 * cave system.
 */
class Excavation {
    const REPLENISH_STONE = 1;
    const INITIAL_STONE_1_TO_3 = 1;
    const INITIAL_STONE_4_TO_7 = 2;
    
    public static function execute(ExcavationActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();

        $player->addStone($actionSpace->getStone());
        $actionSpace->setStone(0);        
    }
    
    public static function replenish(ExcavationActionSpace $actionSpace) {
        if ($actionSpace->getStone() === 0) {
            $actionSpace->setStone( 
                $actionSpace->getGame()->getNumPlayers() < 4 ? 
                self::INITIAL_STONE_1_TO_3 : 
                self::INITIAL_STONE_4_TO_7 
            );
        } else {
            $actionSpace->addStone(self::REPLENISH_STONE);
        }
    }
}