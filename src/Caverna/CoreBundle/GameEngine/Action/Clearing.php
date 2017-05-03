<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\ClearingActionSpace;
use Caverna\CoreBundle\Entity\Player;

use Caverna\CoreBundle\GameEngine\Action\PlaceMeadowFieldTwinTile;

/**
 * Clearing: Take all the Wood that has accumulated on this Action space. (In 
 * games with 1 to 3 players, 1 Wood will be added to this Action space every 
 * round, and 2 Wood in games with 4 to 7 players.) Additionally, you may place 
 * a Meadow/Field twin tile on 2 adjacent Forest spaces of your Home board that 
 * are not covered by any tiles. (Please note the remarks on Stables on page 19 
 * of the rule book.) If you place the twin tile on the small river, you will 
 * get 1 Food from the general supply. If you place the twin tile on one of the 
 * Wild boar preserves, you will get 1 Wild boar from the general supply. The 
 * first tile that you place in the game must be placed adjacent to the cave 
 * entrance. Subsequent tiles must be placed adjacent to other Fields, Meadows 
 * or Pastures.
 */
class Clearing 
{
    public static function execute(ClearingActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();
        
        // take resources
        $player->addWood($actionSpace->getWood());
        $actionSpace->setWood(0);
        
        // place tile
        PlaceMeadowFieldTwinTile::execute($player, $actionSpace->getTile());
    }    
}