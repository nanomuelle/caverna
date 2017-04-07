<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Caverna\CoreBundle\GameEngine;

use Caverna\CoreBundle\Entity\Game;
use Caverna\CoreBundle\Entity\Player;
use Caverna\CoreBundle\Entity\Round;
use Caverna\CoreBundle\Entity\Dwarf;

/**
 * Description of GameBuilder
 *
 * @author marte
 */
class FourPlayersGameBuilder {
    const NUM_STAGES = 3;
    const NUM_ROUNDS = 12;
    
    private static function createHarvestPool() {
        $harvestPool = array(
            Round::HARVEST_NO,
            Round::HARVEST_NO,
            Round::HARVEST_GREEN,
            Round::HARVEST_FEEDING,
            Round::HARVEST_GREEN
        );
                
        $harvestMarkers = array(
            Round::HARVEST_RED,
            Round::HARVEST_RED,
            Round::HARVEST_RED,
            Round::HARVEST_GREEN,
            Round::HARVEST_GREEN,
            Round::HARVEST_GREEN,
            Round::HARVEST_GREEN,
        );
        shuffle($harvestMarkers);
        
        foreach ($harvestMarkers as $harvestMarker) {
            $harvestPool[] = $harvestMarker;
        }
        
        return $harvestPool;
    }    
    private static function createRound($num, $stage, $harvestMarker, Player $initialPlayer) {
        $round = new Round();
        $round->setNum($num);
        $round->setStage($stage);
        $round->setHarvestMarker($harvestMarker);
        $round->setInitialPlayer($initialPlayer);
        
        return $round;
    }
    private static function createRounds(Game $game) {
        $initialPlayer = $game->getPlayers()[0];
        
        $harvests = self::createHarvestPool();
        
        $stage = 0;
        for ($i = 0; $i < self::NUM_ROUNDS; $i++) {
            $num = $i + 1;
            if ($i % self::NUM_STAGES === 0) {
                $stage++;
            }
            $game->addRound(FourPlayersGameBuilder::createRound($num, $stage, $harvests[$i], $initialPlayer));
        }        
    }
    
    private static function createCaveSpaces(Player $player) {
        foreach(range(0, 5) as $row) {
            foreach(range(0, 3) as $col) {
                
                if ($row === 4 && $col === 0) {
                    // initial dwelling
                    $caveSpace = new \Caverna\CoreBundle\Entity\CaveSpace\Dwelling\InitialDwellingCaveSpace();
                } elseif ($row === 3 && $col === 0) {
                    // Cavern
                    $caveSpace = new \Caverna\CoreBundle\Entity\CaveSpace\CavernCaveSpace();
                } else {
                    // mountain space
                    $caveSpace = new \Caverna\CoreBundle\Entity\CaveSpace\MountainCaveSpace();
                }
                
                $caveSpace->setRow($row);
                $caveSpace->setCol($col);
                $player->addCaveSpace($caveSpace);
            }
        }
    }
    private static function createForestSpaces(Player $player) {
        foreach(range(0, 5) as $row) {
            foreach(range(0, 3) as $col) {
                $forestSpace = new \Caverna\CoreBundle\Entity\ForestSpace\ForestForestSpace();
                $forestSpace->setRow($row);
                $forestSpace->setCol($col);

                $player->addForestSpace($forestSpace);
            }
        }
    }
    
    private static function createPlayers(Game $game) {
        $colores = array('rojo', 'verde', 'azul', 'amarillo');
        $food = array(1, 1, 2, 3);
        for ($i = 0; $i < 4; $i++) {
            $player = new Player();
            
            // num
            $player->setNum($i + 1);
            
            // color
            $player->setColor($colores[$i]);
            
            // comida inicial
            $player->setFood($food[$i]);
            
            // enanos iniciales
            $player->addDwarf(new Dwarf());
            $player->addDwarf(new Dwarf());            
            
            $game->addPlayer($player);                                    
        }        
        
        // forest
        foreach($game->getPlayers() as $player) {
            self::createForestSpaces($player);
            self::createCaveSpaces($player);
        }        
    }
    
    private static function createActionSpaces(Game $game) {
        $actionSpaceDefinitions = array(
            array('DriftMining', 1),
            array('Imitation', 1),
            array('Logging', 1),
            array('ForestExploration', 1),
            
            array('Excavation', 1),
            array('Growth', 1),
            array('Clearing', 1),
            
            array('StartingPlayer', 1),
            array('Ore mining', 1),
            array('Sustenance', 1),
            
            array('Ruby mining', 1),
            array('Housework', 1),
            array('SlashAndBurn', 1)
        );
        
        $orderNum = 1;
        $availableFromRoundNum = 1;
        foreach($actionSpaceDefinitions as $actionSpaceDefinition) {
            list($className, $availableFromRoundNum) = $actionSpaceDefinition;
            
            $actionSpaceClass = '\\Caverna\\CoreBundle\\Entity\\ActionSpace\\' . $className .  'ActionSpace';
            if (class_exists($actionSpaceClass)) {
                $actionSpace = new $actionSpaceClass();
                $actionSpace->setAvailableFromRoundNum($availableFromRoundNum);
                $actionSpace->setNum($orderNum);

                $game->addActionSpace($actionSpace);            
            }
            $orderNum++;
        }
    }
    
    public static function create() {
        $game = new Game();
        
        // players
        self::createPlayers($game);
        
        // rounds
        self::createRounds($game);     
        
        // action spaces
        self::createActionSpaces($game);
        
        return $game;
    }
}
