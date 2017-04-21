<?php

namespace AppBundle\Command\Game;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Helper\Table;

use Caverna\CoreBundle\GameEngine\GameEngine;

use AppBundle\Command\GameCommandBase;

/**
 * Description of GameCreateCommand
 *
 * @author marte
 */
class ListCommand extends GameCommandBase {
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);
    }

    protected function configure() {
        $this                
            ->setName('game:list')
            ->setDescription('Listado de partidas.')
            ;        
    }    
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        $games = $this->gameEngineService->gameList();
        $table = new Table($output);
        $table->setStyle('borderless');
        $table
            ->setHeaders(array('id', 'Estado', 'creado', 'NumPlayers', 'Ronda', 'Marcadores Cosecha Rojos'))
        ;
        foreach ($games as $game) {
            $table->addRow(array(
                $game->getId(),
                $game->getStatus(),
                $game->getCreatedAt()->format('Y-m-d'),
                $game->getNumPlayers(),
                $game->getCurrentRound()->getNum() . ' de ' . $game->getRounds()->count(),
                $game->getNumRedHarvestMarkers()
            ));
        }
        
        $table->render();
        $output->writeln('');         
    } 
}
