<?php

namespace AppBundle\Command;

//use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;

use Caverna\CoreBundle\GameEngine\GameEngine;

use Caverna\CoreBundle\Entity\Player;
use Caverna\CoreBundle\Entity\ForestSpace;
use Caverna\CoreBundle\Entity\CaveSpace;

abstract class GameCommandBase extends ContainerAwareCommand {    
    /**
     * @var GameEngine
     */
    protected $gameEngineService;
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct();
        
        $this->gameEngineService = $gameEngineService;
    }

    protected function getForestRows(Player $player) {
        $rows = array(array(),array(),array(),array(),array(),array());
        
        /* @var $forestSpace ForestSpace */
        foreach ($player->getForestSpaces() as $forestSpace) {
            $reflection = new \ReflectionClass($forestSpace);
            $renderer = 'AppBundle\\Renderer\\' . $reflection->getShortName() . 'Renderer';            
            $rows[$forestSpace->getRow()][$forestSpace->getCol()] = $renderer::render($forestSpace);
        }
        
        return $rows;        
    }
    
    protected function getCaveRows(Player $player) {
        $rows = array(array(),array(),array(),array(),array(),array());
        
        /* @var $caveSpace CaveSpace */
        foreach ($player->getCaveSpaces() as $caveSpace) {            
            $reflection = new \ReflectionClass($caveSpace);            
            $renderer = 'AppBundle\\Renderer\\' . $reflection->getShortName() . 'Renderer';            
            $rows[$caveSpace->getRow()][$caveSpace->getCol()] = $renderer::render($caveSpace);
        }
        
        return $rows;
    }    
    
    protected function renderPlayerBoard(OutputInterface $output, Player $player) {
        $forestRows = $this->getForestRows($player);
        $caveRows = $this->getCaveRows($player);
        
        $rows = array();
        for ($row = 0; $row < 6; $row++) {
            $rows[$row] = array_merge($forestRows[$row], $caveRows[$row]);
        }
        
        // http://www.fileformat.info/info/unicode/block/miscellaneous_symbols_and_pictographs/list.htm
        $style = new TableStyle();
        $style
                ->setCellHeaderFormat('')
                ->setCellRowFormat('%s')
                ->setCellHeaderFormat('%s')
                ->setCellRowContentFormat('%s')
                ->setHorizontalBorderChar('')
                ->setVerticalBorderChar('')
                ->setCrossingChar('')
//                ->setBorderFormat('')
//                ->setCrossingChar('')
                ;
        
        
        $table = new Table($output);
//        $table->setStyle('compact');
        $table->setStyle($style);
        $table->addRows($rows);
        $table->render();
        
        $output->writeln('');
    }
    
    protected function renderPlayers(OutputInterface $output, $players) {

        $table = new Table($output);
        $table->setStyle($this::TABLE_STYLE);
        $table
            ->setHeaders(array('id', 'Num', 'Color', 'Enanos', 'Comida', 'Madera', 'Piedra', 'Mineral', 'Ruby', 'VP'))
        ;        
        
        /* @var $player Player */
        foreach ($players as $player) {
            $dwarfs = '';
            for ($i = 0; $i < $player->spaceForDwarfs(); $i++) {
                if ($i < $player->getDwarfs()->count()) {
                    $dwarfs .= $player->getDwarfs()[$i] . "\n";
                } else {
                    $dwarfs .= "[ ]\n";                    
                }
            }
            
            $table->addRow(array(
                '#' . $player->getId(),
                $player->getNum(),
                $player->getColor(),
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
    
    protected function selectTile(InputInterface $input, OutputInterface $output, $tiles) {
        $helper = $this->getHelper('question');        
        $question = new ChoiceQuestion('Selecciona la loseta que quieres:', $tiles, 0);
        $question->getAutocompleterValues($tiles);
        $question->setErrorMessage('La loseta %s no es valida.');        
        return $helper->ask($input, $output, $question);
    }    
    
    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, OutputInterface $output) {
        $this->logger = $this->getContainer()->get('logger');
        $this->logger->notice($this->getName(), $input->getArguments());        
    }
}
