<?php

namespace AppBundle\Command\GameActionSpace;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\ExcavationActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

/**
 * @author marte
 */
class ExcavationCommand extends ActionSpaceCommand {
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = ExcavationActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName('game:action:excavation')
            ->setDescription('Excavation')
            ;        
    }    
}
