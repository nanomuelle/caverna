<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\ClearingActionSpace;

//use AppBundle\Command\GameActionSpace\PlaceMeadowFieldTwinTileCommand;

/**
 * @author marte
 */
class ClearingCommand extends ActionSpaceCommand 
{
    const COMMAND_NAME = 'game:action:clearing';
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = ClearingActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName(self::COMMAND_NAME)
            ->setDescription('Clearing')
            ;        
    }
    
    protected function executeActionSpace(InputInterface $input, OutputInterface $output) {
//        $placeTileCommand = $this->getApplication()->find(PlaceMeadowFieldTwinTileCommand::COMMAND_NAME);
//        $placeTileCommand->run(new ArrayInput(array(
//            'command' => PlaceMeadowFieldTwinTileCommand::COMMAND_NAME,
//            'id' => $input->getArgument('id')
//        )), $output);
    }
}
