<?php

namespace AppBundle\Command\GameActionSpace;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\RubyMiningActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

/**
 * @author marte
 */
class RubyMiningCommand extends ActionSpaceCommand 
{
    const COMMAND_NAME = 'game:action:ruby-mining';
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = RubyMiningActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName(self::COMMAND_NAME)
            ->setDescription('Ruby Mining')
            ;        
    }        
}
