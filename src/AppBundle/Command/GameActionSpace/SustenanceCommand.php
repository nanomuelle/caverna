<?php

namespace AppBundle\Command\GameActionSpace;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\SustenanceActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

/**
 * @author marte
 */
class SustenanceCommand extends ActionSpaceCommand {
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = SustenanceActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName('game:action:sustenance')
            ->setDescription('Sustenance')
            ;        
    }    
}
