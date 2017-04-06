<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\OreMiningActionSpace;
use Caverna\CoreBundle\Entity\Player;

class OreMining {
    
    public static function execute(OreMiningActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();

        $player->addOre($actionSpace->getOre());
        $actionSpace->setOre(0);        
    }
    
    public static function replenish(OreMiningActionSpace $actionSpace) {
        $actionSpace->addOre(OreMiningActionSpace::REPLENISH_WOOD);
    }
}