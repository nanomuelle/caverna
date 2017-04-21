<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\DriftMiningActionSpace;
use Caverna\CoreBundle\Entity\Player;

use Caverna\CoreBundle\Entity\CaveSpace\CavernCaveSpace;
use Caverna\CoreBundle\Entity\CaveSpace\TunnelCaveSpace;
/**
 * Drift mining: Take all the Stone that has accumulated on this Action space. 
 * (In games with 1 to 3 players, 1 Stone will be added to this Action space 
 * every round, and 2 Stone in games with 4 to 7 players. In games with 6 to 7 
 * players, there is an additional “Drift mining” Action space accumulating 1 
 * Stone per round.) Additionally, you may place a Cavern/Tunnel twin tile on 2 
 * adjacent empty Mountain spaces of your Home board. If you place the twin tile
 * on one of the underground water sources, you will immediately get 1 or 2 Food
 * from the general supply. You have to place the twin tile adjacent to an 
 * already occupied Mountain space, i.e. you have to extend your cave system.
 */
class DriftMining {
    const REPLENISH_STONE_1_TO_3_PLAYERS = 1;
    const REPLENISH_STONE_4_TO_7_PLAYERS = 2;
    
    public static function execute(DriftMiningActionSpace $actionSpace, Player $p_player = null) {        
        /* @var $player Player*/
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();
        
        // Stone
        $player->addStone($actionSpace->getStone());
        $actionSpace->setStone(0);
        
        // Cavern / Tunnel
        $cavern = $actionSpace->getCavernCaveSpace();
        $tunnel = $actionSpace->getTunnelCaveSpace();
        if ($cavern !== null && $tunnel !== null) {
            $player->placeCaveSpace($cavern);
            $player->placeCaveSpace($tunnel);
        }
    }
    
    public static function replenish(DriftMiningActionSpace $actionSpace) {
        if ($actionSpace->getGame()->getNumPlayers() < 4) {
            $actionSpace->addStone(self::REPLENISH_STONE_1_TO_3_PLAYERS);
        } else {
            $actionSpace->addStone(self::REPLENISH_STONE_4_TO_7_PLAYERS);
        }        
    }
}