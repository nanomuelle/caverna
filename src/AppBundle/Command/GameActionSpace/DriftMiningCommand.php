<?php

namespace AppBundle\Command\GameActionSpace;

use AppBundle\Command\GameActionSpace\TwinMountainTileCommandBase;
use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\DriftMiningActionSpace;

/**
 * @author marte
 */
class DriftMiningCommand extends TwinMountainTileCommandBase 
{
    const COMMAND_NAME = 'game:action:drift-mining';
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = DriftMiningActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName(self::COMMAND_NAME)
            ->setDescription('Drift Mining')
            ;  
    }    
}