<?php

namespace AppBundle\Command\GameRound;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use Caverna\CoreBundle\GameEngine\GameEngine;
use AppBundle\Command\GameCommandBase;
/**
 * @author marte
 */
class FinishCommand extends GameCommandBase {
    const COMMAND_NAME = 'game:round:finish';

    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);
    }

    protected function configure() {
        $this                
            ->setName(FinishCommand::COMMAND_NAME)
            ->setDescription('Finaliza el turno actual')
            ->addArgument('id', InputArgument::REQUIRED, 'Game Id')
            ;        
    }    
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        parent::execute($input, $output);
        
        $id = $input->getArgument('id');
        $game = $this->gameEngineService->game($id);
        
        $this->gameEngineService->finishCurrentRound($game);
                
        $showCommand = $this->getApplication()->find('game:show');
        $showCommand->run(new ArrayInput(array(
            'command' => 'game:show',
            'id' => $id
        )), $output);
    } 
}
