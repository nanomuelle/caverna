<?php

namespace AppBundle\Command\GameActionSpace;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\ForestExplorationActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

/**
 * @author marte
 */
class ForestExplorationCommand extends ActionSpaceCommand {
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = ForestExplorationActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName('game:action:forest-exploration')
            ->setDescription('Forest Exploration')
            ;        
    }
}
