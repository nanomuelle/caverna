<?php

namespace AppBundle\Command\Game;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;

use AppBundle\Command\GameCommandBase;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\Game;
use Caverna\CoreBundle\Entity\Player;
use Caverna\CoreBundle\Entity\Round;
use Caverna\CoreBundle\Entity\Turn;

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
        $this->renderPlayerBoard($output, $player);
    } 
}
