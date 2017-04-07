<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\ForestExplorationActionSpace;
use Caverna\CoreBundle\Entity\Player;

/**
 * Forest exploration (3-7 players): Take all the Wood that has accumulated on 
 * this Action space. (In 3-player games, this Action space can be found on the
 * additional game board: every round, 1 Wood will be added to it. In games 
 * with 4 or more players, it can be found on the two-sided basic game board: 
 * every round, 1 Wood will be added to it unless it is empty. Then 2 Wood will 
 * be added to it instead.) In 3-player games, also take 1 Vegetable. In games 
 * with 4 or more players, also take 2 Food.
 */
class ForestExploration {
    const REPLENISH_WOOD = 1;
    
    const INITIAL_WOOD_3_PLAYERS = 1;
    const VEGETABLES_3_PLAYERS = 1;
    
    const INITIAL_WOOD_4_TO_7_PLAYERS = 2;
    const FOOD_4_TO_7_PLAYERS = 2;
    
    public static function execute(ForestExplorationActionSpace $actionSpace, Player $p_player = null) {
        $player = $p_player ? $p_player : $actionSpace->getDwarf()->getPlayer();

        $player->addWood($actionSpace->getWood());
        $actionSpace->setWood(0);        
        if ($actionSpace->getGame()->getNumPlayers() < 4) {
            $player->addVegetable(self::VEGETABLES_3_PLAYERS);
        } else {
            $player->addFood(self::FOOD_4_TO_7_PLAYERS);
        }
    }
    
    public static function replenish(ForestExplorationActionSpace $actionSpace) {
        if ($actionSpace->getWood() === 0) {
            $actionSpace->setWood(
                $actionSpace->getGame()->getNumPlayers() < 4 ?
                    self::INITIAL_WOOD_3_PLAYERS :
                    self::INITIAL_WOOD_4_TO_7_PLAYERS
            );
        } else {
            $actionSpace->addWood(self::REPLENISH_WOOD);
        }
    }
}