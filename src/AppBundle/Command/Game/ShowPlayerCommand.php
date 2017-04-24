<?php

namespace AppBundle\Command\Game;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use AppBundle\Command\GameCommandBase;

use Caverna\CoreBundle\GameEngine\GameEngine;

/**
 * @author marte
 */
class ShowPlayerCommand extends GameCommandBase {
    const TABLE_STYLE = 'borderless';
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);
    }

    protected function configure() {
        $this                
            ->setName('game:show:player')
            ->setDescription('Vista de un player de una partida.')
            ->addArgument('id', InputArgument::REQUIRED, 'Game Id')
            ->addArgument('numPlayer', InputArgument::REQUIRED, 'Numero de player')
            ;        
    }    
    
    protected function execute(InputInterface $input, OutputInterface $output) {        
        parent::execute($input, $output);
        
        $id = $input->getArgument('id');
        $game = $this->gameEngineService->game($id);
        
        $numPlayer = $input->getArgument('numPlayer');
        $player = $game->getPlayerByNum($numPlayer);
        
        if ($player === null) {
            $output->writeln('');
            $output->writeln('<error>                           </>');
            $output->writeln('<error>  Jugador ' . $numPlayer . ' no encontrado  </>');
            $output->writeln('<error>                           </>');
            return;
        }
        
        $this->renderPlayers($output, array($player));
        $this->renderPlayerBoard($output, $player);
    } 
}
