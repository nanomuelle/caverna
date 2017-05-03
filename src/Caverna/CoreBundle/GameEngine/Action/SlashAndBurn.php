<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\SlashAndBurnActionSpace;
use Caverna\CoreBundle\Entity\Player;

use Caverna\CoreBundle\GameEngine\Action\PlaceMeadowFieldTwinTile;

/**
 * Slash-and-burn: Place a Meadow/Field twin tile on 2 adjacent Forest spaces 
 * of your Home board that are not covered by any tiles. (See “Clearing” for 
 * further details.) Afterwards, you may carry out a Sow action to sow up 
 * to 2 new Grain and/or up to 2 new Vegetable fields (as usual).
 *
 * @author marte
 */
class SlashAndBurn 
{
    public static function executePlaceMeadowFieldTwinTile(SlashAndBurnActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();
        
        // place tile
        PlaceMeadowFieldTwinTile::execute($player, $actionSpace->getTile());
    }
    
    public static function executeSow(SlashAndBurnActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();

        // sow
        foreach ($actionSpace->getFieldForestSpacesForGrain as $fieldForestSpace) {
            $fieldForestSpace->sowGrain();
        }
        
        foreach ($actionSpace->getFieldForestSpacesForVegetable as $fieldForestSpace) {
            $fieldForestSpace->sowVegetable();
        }        
    }    
}
