<?php

namespace AppBundle\Command\GameActionSpace;

use AppBundle\Command\GameActionSpace\TwinCavernTileCommandBase;
use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\ExcavationActionSpace;

/**
 * @author marte
 */
class ExcavationCommand extends TwinCavernTileCommandBase 
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
