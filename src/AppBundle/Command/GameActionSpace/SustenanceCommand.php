<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\SustenanceActionSpace;
use Caverna\CoreBundle\GameEngine\Action\Sustenance;

/**
 * @author marte
 */
class SustenanceCommand extends ActionSpaceCommand 
{
    const COMMAND_NAME = 'game:action:sustenance';
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = SustenanceActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Sustenance')
            ;        
    }    
    
    protected function executeActionSpace(InputInterface $input, OutputInterface $output) {
        Sustenance::execute($this->actionSpace, $this->player, $this->options);
    }    
}
