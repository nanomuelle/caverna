<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\ForestExplorationActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;
use Caverna\CoreBundle\GameEngine\Action\ForestExploration;

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
    
    protected function executeActionSpace(InputInterface $input, OutputInterface $output) {
        ForestExploration::execute($this->actionSpace, $this->player, $this->options);
    }    
}
