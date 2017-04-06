<?php

namespace AppBundle\Command\Game;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
# use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Console\Helper\Table;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\Game;
use Caverna\CoreBundle\Entity\Player;
use Caverna\CoreBundle\Entity\Round;
use Caverna\CoreBundle\Entity\Turn;
use Caverna\CoreBundle\Entity\ForestSpace;

/**
 * @author marte
 */
class ShowCommand extends Command {
    const TABLE_STYLE = 'borderless';
    
    protected $gameEngineService;
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct();
        
        $this->gameEngineService = $gameEngineService;
    }

    protected function configure() {
        $this                
            ->setName('game:show')
            ->setDescription('Vista de partida.')
            ->addArgument('id', InputArgument::REQUIRED, 'Game Id')
            ;        
    }    
    
    private function renderGame(OutputInterface $output, Game $game) {
        $table = new Table($output);
        $table->setStyle(self::TABLE_STYLE);
        
        $table
            ->setHeaders(array('id', 'Estado', 'Jugadores', 'Ronda', 'Cosecha Rojos', 'creado'))
        ;
        $table->addRow(array(
            '#' . $game->getId(),
            $game->getStatus(),
            $game->getNumPlayers(),
            $game->getCurrentRound()->getNum() . ' de ' . $game->getRounds()->count(),
            $game->getNumRedHarvestMarkers(),
            $game->getCreatedAt()->format('Y-m-d'),
        ));
        
        $table->render();
        $output->writeln('');        
    }
    
    private function renderRound(OutputInterface $output, Round $round) {
        $table = new Table($output);
        $table->setStyle(self::TABLE_STYLE);
        
        $table
            ->setHeaders(array('id', 'Fase', 'Ronda', 'Jugador Inicial', 'Cosecha', 'Turno'))
        ;
        
        $turn = $round->getCurrentTurn() ? $round->getCurrentTurn()->getNum() . ' de ' . $round->getTurns()->count() : '';
        $table->addRow(array(
            '#' . $round->getId(),            
            $round->getStage(),
            $round->getNum(),
            $round->getInitialPlayer(),
            $round->getHarvestMarker(),
            $turn
        ));
        
        $table->render();
        $output->writeln('');        
    }
    
    private function renderTurn(OutputInterface $output, Turn $turn) {
        $table = new Table($output);
        $table->setStyle(self::TABLE_STYLE);
        
        $table->setHeaders(array('id', 'Num', 'Jugador', 'Jugada'));
        
        $table->addRow(array(
            '#' . $turn->getId(),
            $turn->getNum(),
            $turn->getPlayer(),
            $turn->getActionSpace() ? $turn->getActionSpace()->getDwarf() : ''
        ));
        
        $table->render();
        $output->writeln('');
        $output->writeln('Tablero ' . $turn->getPlayer());
        $this->renderForest($output, $turn->getPlayer());
    }
    
    private function renderForest(OutputInterface $output, Player $player) {
        $rows = array(array(),array(),array(),array());
        
        /* @var $forestSpace ForestSpace */
        foreach ($player->getForestSpaces() as $forestSpace) {
            $rows[$forestSpace->getRow()][$forestSpace->getCol()] = $forestSpace;
        }
        
        $table = new Table($output);
        $table->setStyle('compact');
        $table->addRows($rows);
        $table->render();
        
        $output->writeln('');
    }
    
    private function renderActionSpaces(OutputInterface $output, Game $game) {
        $actionSpaces = $game->getActionSpaces();
        $table = new Table($output);
        $table->setStyle($this::TABLE_STYLE);
        $table
            ->setHeaders(array('', 'Accion', 'Descripcion', 'Estado', 'Enano'))
        ;
        foreach ($actionSpaces as $actionSpace) {
            $dwarf = $actionSpace->getDwarf() ? $actionSpace->getDwarf() : '';
            $table->addRow(array(
                $actionSpace->isAvailable() ? '' : '-',
                $actionSpace->getKey(),
                $actionSpace->getDescription(),
                $actionSpace->getState(),
                $dwarf ? $dwarf->getName() : ''
            ));
        }
        
        $table->render();
        $output->writeln('');        
    }
    
    private function renderPlayers(OutputInterface $output, Game $game) {
        $players = $game->getPlayers();
        $table = new Table($output);
        $table->setStyle($this::TABLE_STYLE);
        $table
            ->setHeaders(array('id', 'Num', 'Color', 'Enanos', 'Comida', 'Madera', 'Piedra', 'Mineral', 'Ruby', 'VP'))
        ;        
        foreach ($players as $player) {
            $dwarfs = '';
            
            foreach ($player->getDwarfs() as $dwarf) {
                $dwarfs .= $dwarf . "\n";
            }
            
            $table->addRow(array(
                '#' . $player->getId(),
                $player->getNum(),
                $player->getColor(),
//                $player->getDwarfs()->count(),
                $dwarfs,
                $player->getFood(),
                $player->getWood(),
                $player->getStone(),
                $player->getOre(),
                $player->getRuby(),
                $player->getVp()
            ));
        }
        
        $table->render();
        $output->writeln('');        
    }
        
    protected function execute(InputInterface $input, OutputInterface $output) {
        $id = $input->getArgument('id');
        $game = $this->gameEngineService->game($id);
        $output->writeln('Partida');
        $this->renderGame($output, $game);
        
        $output->writeln('Jugadores');
        $this->renderPlayers($output, $game);
        
        $output->writeln('Action Spaces');
        $this->renderActionSpaces($output, $game);
        
        $output->writeln('Ronda Actual');
        $this->renderRound($output, $game->getCurrentRound());
        
        if ($game->getCurrentRound()->getCurrentTurn()) {
            $output->writeln('Turno Actual');
            $this->renderTurn($output, $game->getCurrentRound()->getCurrentTurn());        
        }
    } 
}
