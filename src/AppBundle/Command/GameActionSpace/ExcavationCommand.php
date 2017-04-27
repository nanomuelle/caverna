<?php

namespace AppBundle\Command\GameActionSpace;

use AppBundle\Command\GameActionSpace\TwinMountainTileCommandBase;
use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\ExcavationActionSpace;

/**
 * @author marte
 */
class ExcavationCommand extends TwinMountainTileCommandBase 
{
    const COMMAND_NAME = 'game:action:excavation';
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = ExcavationActionSpace::KEY;        
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName(self::COMMAND_NAME)
            ->setDescription('Excavation')
            ;        
    }    
}
