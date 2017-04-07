<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\StartingPlayerActionSpace;

/**
 * Starting player: Take the Starting player token and all the Food that has 
 * accumulated on this Action space. Additionally, take 2 Ore (in games 
 * with 1 to 3 players) or 1 Ruby (in games with 4 to 7 players) from the 
 * general supply. (1 Food is added to this Action space every round.)
 */
class StartingPlayer {
    const REPLENISH_FOOD = 1;
    const ORE_1_TO_3_PLAYERS = 2;
    const RUBY_4_TO_7_PLAYERS = 1;
    
    public static function execute(StartingPlayerActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();
        $game = $actionSpace->getGame();

        $player->addFood($actionSpace->getFood());
        $actionSpace->setFood(0);        
        
        if ($game->getNumPlayers() < 4) {
            $player->addOre(self::ORE_1_TO_3_PLAYERS);
        } else {
            $player->addRuby(self::RUBY_4_TO_7_PLAYERS);
        }
        
        $rounds = $game->getRounds();
        $currentRoundNum = $game->getCurrentRound()->getNum();        
        foreach ($rounds as $round) {
            if ($round->getNum() > $currentRoundNum) {
                $round->setInitialPlayer($player);
            }
        }        
    }
    
    public static function replenish(StartingPlayerActionSpace $actionSpace) {
        $actionSpace->addFood(self::REPLENISH_FOOD);
    }
}