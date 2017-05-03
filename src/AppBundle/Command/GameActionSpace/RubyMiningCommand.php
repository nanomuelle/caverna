<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\RubyMiningActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;
use Caverna\CoreBundle\GameEngine\Action\RubyMining;

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
    
    protected function executeActionSpace(InputInterface $input, OutputInterface $output) {
        RubyMining::execute($this->actionSpace, $this->player, $this->options);
    }
}
