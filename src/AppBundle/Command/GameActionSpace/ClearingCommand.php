<?php

namespace AppBundle\Command\GameActionSpace;

use AppBundle\Command\GameActionSpace\TwinForestTileCommandBase;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\ClearingActionSpace;

/**
 * @author marte
 */
class ClearingCommand extends TwinForestTileCommandBase 
{
    const COMMAND_NAME = 'game:action:clearing';
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = ClearingActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName(self::COMMAND_NAME)
            ->setDescription('Clearing')
            ;        
    }    
}
