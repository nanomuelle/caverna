<?php

namespace AppBundle\Command\GameActionSpace;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\ClearingActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

/**
 * @author marte
 */
class ClearingCommand extends ActionSpaceCommand {
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = ClearingActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName('game:action:clearing')
            ->setDescription('Clearing')
            ;        
    }    
}
