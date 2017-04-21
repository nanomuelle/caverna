<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;

use Caverna\CoreBundle\GameEngine\GameEngine;

use Caverna\CoreBundle\Entity\Player;
use Caverna\CoreBundle\Entity\ForestSpace;
use Caverna\CoreBundle\Entity\CaveSpace;

abstract class GameCommandBase extends Command {
    /**
     * @var GameEngine
     */
    protected $gameEngineService;
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct();
        
        $this->gameEngineService = $gameEngineService;
    }
    
    protected function getForestRows(Player $player) {
        $rows = array(array(),array(),array(),array(),array(),array());
        
        /* @var $forestSpace ForestSpace */
        foreach ($player->getForestSpaces() as $forestSpace) {
            $reflection = new \ReflectionClass($forestSpace);
            $renderer = 'AppBundle\\Renderer\\' . $reflection->getShortName() . 'Renderer';            
            $rows[$forestSpace->getRow()][$forestSpace->getCol()] = $renderer::render($forestSpace);
        }
        
        return $rows;        
    }
    
    protected function getCaveRows(Player $player) {
        $rows = array(array(),array(),array(),array(),array(),array());
        
        /* @var $caveSpace CaveSpace */
        foreach ($player->getCaveSpaces() as $caveSpace) {            
            $reflection = new \ReflectionClass($caveSpace);            
            $renderer = 'AppBundle\\Renderer\\' . $reflection->getShortName() . 'Renderer';            
            $rows[$caveSpace->getRow()][$caveSpace->getCol()] = $renderer::render($caveSpace);
        }
        
        return $rows;
    }    
    
}
