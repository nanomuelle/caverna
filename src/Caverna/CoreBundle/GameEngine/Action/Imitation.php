<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\ImitationActionSpace;
use Caverna\CoreBundle\Entity\Player;

class Imitation {
    public static function execute(ImitationActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();

        $player->addFood(-ImitationActionSpace::FOOD_COST);
        
        $imitatedActionSpace = $actionSpace->getImitatedActionSpace();
        
        $actionClass = '\\Caverna\CoreBundle\\GameEngine\\Action\\' . $imitatedActionSpace->getKey();
        $actionClass::execute($imitatedActionSpace, $player);        
    }
    
    public static function replenish(ImitationActionSpace $actionSpace) {
        return;
    }
}