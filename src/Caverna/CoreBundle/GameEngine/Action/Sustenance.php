<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\SustenanceActionSpace;
use Caverna\CoreBundle\Entity\Player;

/**
 * Sustenance: Take all the goods or Food markers that have accumulated on this 
 * Action space. (In games with 1 to 3 players, 1 Food will be added to this 
 * Action space every round. In games with 4 to 7 players, 1 Vegetable will be 
 * added to it every round unless it is empty. Then 1 Grain will be added to it 
 * instead.) In games with 1 to 3 players, also take 1 Grain from the general 
 * supply. Additionally, you may place a Meadow/Field twin tile on 2 adjacent 
 * Forest spaces of your Home board that are not covered by any tiles. 
 * (See “Clearing” for further details.)
 */
class Sustenance {
    
    public static function execute(SustenanceActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();

        if ($actionSpace->getGame()->getNumPlayers() < 4) {
            $player->addFood($actionSpace->getFood());
            $actionSpace->setFood(0);

            $player->addGrain($actionSpace->getGrain());
        }
        
        if ($actionSpace->getGame()->getNumPlayers() >= 4) {
            $player->addGrain($actionSpace->getGrain());
            $actionSpace->setGrain(0);
            
            $player->addVegetable($actionSpace->getVegetable());
            $actionSpace->setVegetable(0);
        }
    }
    
    public static function replenish(SustenanceActionSpace $actionSpace) {
        if ($actionSpace->getGame()->getNumPlayers() < 4) {
            $actionSpace->addFood(SustenanceActionSpace::REPLENISH_FOOD);
        }
        
        if ($actionSpace->getGame()->getNumPlayers() >= 4) {
            if ($actionSpace->getGrain() === 0) {
                $actionSpace->setGrain(SustenanceActionSpace::GRAIN);
            } else {
                $actionSpace->addVegetable(SustenanceActionSpace::REPLENISH_VEGETABLE);
            }
        }
    }
}