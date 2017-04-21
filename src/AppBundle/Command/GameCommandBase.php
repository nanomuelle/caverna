<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
# use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\Game;
use Caverna\CoreBundle\Entity\Player;
use Caverna\CoreBundle\Entity\Round;
use Caverna\CoreBundle\Entity\Turn;
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
    
    
}
