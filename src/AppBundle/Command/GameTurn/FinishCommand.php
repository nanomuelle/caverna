<?php

namespace AppBundle\Command\GameTurn;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use Caverna\CoreBundle\GameEngine\GameEngine;

/**
 * @author marte
 */
class FinishCommand extends Command {
    protected $gameEngineService;
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct();
        
        $this->gameEngineService = $gameEngineService;
    }

    protected function configure() {
        $this                
            ->setName('game:turn:finish')
            ->setDescription('Finaliza el turno actual')
            ->addArgument('id', InputArgument::REQUIRED, 'Game Id')
            ;        
    }    
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        $id = $input->getArgument('id');
        $game = $this->gameEngineService->game($id);
        
        $this->gameEngineService->finishCurrentTurn($game);
                
        $showCommand = $this->getApplication()->find('game:show');
        $showCommand->run(new ArrayInput(array(
            'command' => 'game:show',
            'id' => $id
        )), $output);
    } 
}
