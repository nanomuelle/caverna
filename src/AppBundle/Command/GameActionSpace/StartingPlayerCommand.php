<?php

namespace AppBundle\Command\GameActionSpace;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\StartingPlayerActionSpace;
use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

/**
 * @author marte
 * 
 */
class StartingPlayerCommand extends ActionSpaceCommand {
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = StartingPlayerActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName('game:action:starting-player')
            ->setDescription('Starting Player')
            ;        
    }
    
}
