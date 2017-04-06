<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\LoggingActionSpace;
use Caverna\CoreBundle\Entity\Player;

class Logging {
    
    public static function execute(LoggingActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();

        $player->addWood($actionSpace->getWood());
        $actionSpace->setWood(0);        
    }
    
    public static function replenish(LoggingActionSpace $actionSpace) {
        $actionSpace->addWood(LoggingActionSpace::REPLENISH_WOOD);
    }
}