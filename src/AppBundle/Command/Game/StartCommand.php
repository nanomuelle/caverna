<?php

namespace AppBundle\Command\Game;

use Symfony\Component\Console\Input\InputInterface;
// use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use Caverna\CoreBundle\GameEngine\GameEngine;
use AppBundle\Command\GameCommandBase;

/**
 * @author marte
 */
class StartCommand extends GameCommandBase 
{
    const COMMAND_NAME = 'game:start';
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);
    }

    protected function configure() {
        $this                
            ->setName(self::COMMAND_NAME)
            ->setDescription('Da comienzo a una partida.')
            ->addArgument('id', InputArgument::REQUIRED, 'Game Id')
            ;        
    }    
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        parent::execute($input, $output);
        
        $id = $input->getArgument('id');
        $game = $this->gameEngineService->game($id);
        
        $this->gameEngineService->startGame($game);
        
        $showCommand = $this->getApplication()->find('game:show');        
        $showCommand->run(new ArrayInput(array(
            'command' => 'game:show',
            'id' => $id
        )), $output);
    } 
}
