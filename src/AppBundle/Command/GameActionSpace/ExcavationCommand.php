<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Command\GameActionSpace\TwinMountainTileCommandBase;
use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\ExcavationActionSpace;

use Caverna\CoreBundle\GameEngine\Action\Excavation;
/**
 * @author marte
 */
class ExcavationCommand extends TwinMountainTileCommandBase 
{
    const COMMAND_NAME = 'game:action:excavation';
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = ExcavationActionSpace::KEY;        
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName(self::COMMAND_NAME)
            ->setDescription('Excavation')
            ;
    }    
    
    protected function executeActionSpace(InputInterface $input, OutputInterface $output) {
        Excavation::execute($this->actionSpace, $this->player, $this->options);
    }    
}
