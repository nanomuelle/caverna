<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Command\GameActionSpace\TwinMountainTileCommandBase;
use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\DriftMiningActionSpace;
use Caverna\CoreBundle\GameEngine\Action\DriftMining;

/**
 * @author marte
 */
class DriftMiningCommand extends TwinMountainTileCommandBase 
{
    const COMMAND_NAME = 'game:action:drift-mining';
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = DriftMiningActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName(self::COMMAND_NAME)
            ->setDescription('Drift Mining')
            ;  
    }
    
    protected function executeActionSpace(InputInterface $input, OutputInterface $output) {
        DriftMining::execute($this->actionSpace, $this->player, $this->options);
    }
}