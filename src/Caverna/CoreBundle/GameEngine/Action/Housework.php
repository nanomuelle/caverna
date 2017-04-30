<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\HouseworkActionSpace;
use Caverna\CoreBundle\Entity\Player;

/**
 * Housework: Take 1 Dog from the general supply. Additionally or alternatively, 
 * take a Furnishing tile, pay its building costs and place it on an empty 
 * Cavern in your cave system. You may choose from all Furnishing tiles 
 * (including Dwellings). If you cannot place a Furnishing tile on your Home 
 * board, you may not take any. (This is an “and/or” Action space; you may carry 
 * out the actions in either order. For instance, you might want to take the Dog 
 * after building the “Dog school”.)
 *
 * @author marte
 */
class Housework 
{
    const DOG = 1;
    
    public static function execute(HouseworkActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();
        
        // TODO: place furnishing        
        // TODO: allow interchange order of furnishing and addDog
        $player->addDog(self::DOG);
    }
   
}
