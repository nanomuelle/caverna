<?php

namespace AppBundle\Command\GameActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\SustenanceActionSpace;

/**
 * @author marte
 */
class SustenanceCommand extends ActionSpaceCommand 
{
    const COMMAND_NAME = 'game:action:sustenance';
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = SustenanceActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Sustenance')
            ;        
    }    
}
