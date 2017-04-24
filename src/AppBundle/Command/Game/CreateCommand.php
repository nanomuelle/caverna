<?php

namespace AppBundle\Command\Game;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use AppBundle\Command\GameCommandBase;
use Caverna\CoreBundle\GameEngine\GameEngine;

/**
 * Description of GameCreateCommand
 *
 * @author marte
 */
class CreateCommand extends GameCommandBase {
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);
    }

    protected function configure() {
        $this                
            ->setName('game:create')
            ->setDescription('Crea una nueva partida de n jugadores.')
            ->addArgument('n', InputArgument::OPTIONAL, 'Numero de jugadores', 4)
            ;        
    }    
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        parent::execute($input, $output);
        
        $n = $input->getArgument('n');        
        $game = $this->gameEngineService->newGame($n);
        $output->writeln([
            'Se ha creado una nueva partida con el id: ' + $game->getId()
        ]);
    }    
}
