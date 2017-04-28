<?php

namespace AppBundle\Command\GameActionSpace;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\HouseworkActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

/**
 * @author marte
 */
class HouseworkCommand extends ActionSpaceCommand 
{
    const COMMAND_NAME = 'game:action:housework';
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = HouseworkActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName(self::COMMAND_NAME)
            ->setDescription('Housework')
            ;
    }        
}
