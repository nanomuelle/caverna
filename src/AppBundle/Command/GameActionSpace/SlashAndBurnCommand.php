<?php

namespace AppBundle\Command\GameActionSpace;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\SlashAndBurnActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

/**
 * @author marte
 */
class SlashAndBurnCommand extends ActionSpaceCommand 
{
    const COMMAND_NAME = 'game:action:slash-and-burn';
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = SlashAndBurnActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName(self::COMMAND_NAME)
            ->setDescription('Slash and burn')
            ;
    }        
}
