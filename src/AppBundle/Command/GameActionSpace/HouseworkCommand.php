<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\HouseworkActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;
use Caverna\CoreBundle\GameEngine\Action\Housework;

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
    
    protected function executeActionSpace(InputInterface $input, OutputInterface $output) {
        Housework::execute($this->actionSpace, $this->player, $this->options);
    }     
}
