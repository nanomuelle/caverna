<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\GrowthActionSpace;
use Caverna\CoreBundle\Entity\Player;

class Growth {
    
    public static function execute(GrowthActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();
        
        $player->addFood($actionSpace->getFood());
        $player->addWood($actionSpace->getWood());
        $player->addStone($actionSpace->getStone());
        $player->addOre($actionSpace->getOre());
        $player->addVp($actionSpace->getVp());
    }
    
    public static function replenish(GrowthActionSpace $actionSpace) {
        return;
    }
}