<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\StartingPlayerActionSpace;

class StartingPlayer {
    
    public static function execute(StartingPlayerActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();
        $game = $actionSpace->getGame();

        $player->addFood($actionSpace->getFood());
        $actionSpace->setFood(0);        
        
        $player->addOre($actionSpace->getOre());
        $player->addRuby($actionSpace->getRuby());
        
        $rounds = $game->getRounds();
        $currentRoundNum = $game->getCurrentRound()->getNum();        
        foreach ($rounds as $round) {
            if ($round->getNum() > $currentRoundNum) {
                $round->setInitialPlayer($player);
            }
        }        
    }
    
    public static function replenish() {
        $this->actionSpace->addFood(StartingPlayerActionSpace::REPLENISH_FOOD);
    }
}