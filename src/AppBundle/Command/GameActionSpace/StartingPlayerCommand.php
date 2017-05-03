<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\StartingPlayerActionSpace;
use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

use Caverna\CoreBundle\GameEngine\Action\StartingPlayer;
/**
 * @author marte
 * 
 */
class StartingPlayerCommand extends ActionSpaceCommand {
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = StartingPlayerActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName('game:action:starting-player')
            ->setDescription('Starting Player')
            ;        
    }
 
    protected function executeActionSpace(InputInterface $input, OutputInterface $output) {
        StartingPlayer::execute($this->actionSpace, $this->player, $this->options);
    }    
}
