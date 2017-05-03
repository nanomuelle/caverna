<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\LoggingActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

use Caverna\CoreBundle\GameEngine\Action\Logging;

/**
 * @author marte
 */
class LoggingCommand extends ActionSpaceCommand {
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = LoggingActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName('game:action:logging')
            ->setDescription('Logging')
            ;        
    }
    
    protected function executeActionSpace(InputInterface $input, OutputInterface $output) {
        Logging::execute($this->actionSpace, $this->player, $this->options);
    }
}
