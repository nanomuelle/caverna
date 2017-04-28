<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\OreMiningActionSpace;
use Caverna\CoreBundle\Entity\Player;

class OreMining 
{
    const INITIAL_ORE = 3;
    const REPLENISH_ORE = 2;
        
    public static function execute(OreMiningActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();

        $player->addOre($actionSpace->getOre());
        $actionSpace->setOre(0);        
    }
    
    public static function replenish(OreMiningActionSpace $actionSpace) {
        if ($actionSpace->getOre() === 0) {
            $actionSpace->setOre(self::INITIAL_ORE);
        } else {
            $actionSpace->addOre(self::REPLENISH_ORE);
        }
    }
}