<?php

namespace AppBundle\Command\Game;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Console\Helper\Table;

use AppBundle\Command\GameCommandBase;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\Game;
use Caverna\CoreBundle\Entity\Player;
use Caverna\CoreBundle\Entity\Round;
use Caverna\CoreBundle\Entity\Turn;

/**
 * @author marte
 */
class ShowCommand extends GameCommandBase {
    const COMMAND_NAME = 'game:show';
    const TABLE_STYLE = 'borderless';
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);
    }

    protected function configure() {
        $this                
            ->setName(self::COMMAND_NAME)
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
        $this->renderPlayerBoard($output, $turn->getPlayer());
    }
    
    private function renderActionSpaces(OutputInterface $output, Game $game) {
        $actionSpaces = $game->getActionSpaces();
        $table = new Table($output);
        $table->setStyle($this::TABLE_STYLE);
        $table
            ->setHeaders(array('', 'Accion', 'Estado', 'Enano'))
        ;
        foreach ($actionSpaces as $actionSpace) {
            $dwarf = $actionSpace->getDwarf() ? $actionSpace->getDwarf() : '';
            $table->addRow(array(
                $actionSpace->isAvailable() ? '' : '-',
                $actionSpace->getKey(),
//                $actionSpace->getDescription(),
                $actionSpace->getState(),
                $dwarf ? $dwarf->getName() : ''
            ));
        }
        
        $table->render();
        $output->writeln('');        
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        parent::execute($input, $output);
        
        $id = $input->getArgument('id');
        $game = $this->gameEngineService->game($id);
        $output->writeln('Partida');
        $this->renderGame($output, $game);
        
        $output->writeln('Jugadores');
        $this->renderPlayers($output, $game->getPlayers());
        
        $output->writeln('Action Spaces');
        $this->renderActionSpaces($output, $game);
        
        $output->writeln('Ronda Actual');
        $this->renderRound($output, $game->getCurrentRound());
        
        if ($game->getCurrentRound()->getCurrentTurn()) {
            $output->writeln('<info>Turno Actual</info>');
            $this->renderTurn($output, $game->getCurrentRound()->getCurrentTurn());        
        }
    } 
}
