<?php

namespace AppBundle\Command\Game;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Console\Helper\Table;
use Doctrine\ORM\EntityManager;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\Game;

/**
 * Description of GameCreateCommand
 *
 * @author marte
 */
class ListCommand extends Command {
    //put your code here
    
    protected $gameEngineService;
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct();
        
        $this->gameEngineService = $gameEngineService;
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
