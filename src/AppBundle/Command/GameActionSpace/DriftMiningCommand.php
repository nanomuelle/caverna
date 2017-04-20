<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\DriftMiningActionSpace;
use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

use Caverna\CoreBundle\Entity\CaveSpace\CavernCaveSpace;
use Caverna\CoreBundle\Entity\CaveSpace\TunnelCaveSpace;
use Caverna\CoreBundle\Entity\Player;


/**
 * @author marte
 */
class DriftMiningCommand extends ActionSpaceCommand {
    const TILE_NINGUNO = "Ninguno";
    const TILE_TC_HORIZONTAL = "Tunel/Caverna Horizontal";
    const TILE_CT_HORIZONTAL = "Caverna/Tunel Horizontal";
    const TILE_TC_VERTICAL = "Tunel/Caverna Vertical";
    const TILE_CT_VERTICAL = "Caverna/Tunel Vertical";
    
    /**
     * @var $cavern CavernCaveSpace
     */
    private $cavern;
    
    /**
     * @var $tunnel TunnelCaveSpace
     */
    private $tunnel;
    
    private $tile;
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = DriftMiningActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName('game:action:drift-mining')
            ->setDescription('Drift Mining')
            ;  
    }
    
    protected function selectTile(InputInterface $input, OutputInterface $output) {
        $helper = $this->getHelper('question');
        
        $tiles = array(self::TILE_NINGUNO, self::TILE_TC_HORIZONTAL, 
            self::TILE_CT_HORIZONTAL, self::TILE_TC_VERTICAL, self::TILE_CT_VERTICAL);
        
        $question = new ChoiceQuestion('Selecciona la loseta que quieres:', $tiles, 0);
        $question->getAutocompleterValues($tiles);
        $question->setErrorMessage('La loseta %s no es valida.');
        $selectedActionSpace = $helper->ask($input, $output, $question);
        
        return $selectedActionSpace;
    }
    
    private function getForestRows(Player $player) {
        $rows = array(array(),array(),array(),array(),array(),array());
        
        /* @var $forestSpace ForestSpace */
        foreach ($player->getForestSpaces() as $forestSpace) {
            $reflection = new \ReflectionClass($forestSpace);
            $renderer = 'AppBundle\\Renderer\\' . $reflection->getShortName() . 'Renderer';            
            $rows[$forestSpace->getRow()][$forestSpace->getCol()] = $renderer::render($forestSpace);
        }
        
        return $rows;        
    }
    
    private function getCaveRows(Player $player) {
        $rows = array(array(),array(),array(),array(),array(),array());
        
        $keys = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $contador = 0;
        /* @var $caveSpace CaveSpace */
        foreach ($player->getCaveSpaces() as $caveSpace) {
//            $rows[$caveSpace->getRow()][$caveSpace->getCol()] = $caveSpace;
            
            switch ($this->tile) {
                case self::TILE_TC_HORIZONTAL:
                    // TODO. crear metodo $caveSpace->acceptsTile()
                    if ($caveSpace->acceptsTile($this->tile)) {
                        $key = $keys[$contador];
                    } else {
                        $key = '';
                    }
                    break;
                    
                default:
                    $key = '';
            }
            
            $reflection = new \ReflectionClass($caveSpace);            
            $renderer = 'AppBundle\\Renderer\\' . $reflection->getShortName() . 'Renderer';
            $rows[$caveSpace->getRow()][$caveSpace->getCol()] = $renderer::render($caveSpace, $key);
            $contador++;
        }
        
        return $rows;
    }
    
    private function renderPlayerBoard(OutputInterface $output, Player $player) {
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
                ;
        
        
        $table = new Table($output);
        $table->setStyle($style);
        $table->addRows($rows);
        $table->render();
        
        $output->writeln('');
    }
    
    protected function selectPos(InputInterface $input, OutputInterface $output) {
        $this->renderPlayerBoard($output, $this->player);
    }
    
    protected function interact(InputInterface $input, OutputInterface $output) {
        parent::interact($input, $output);
        
        /* @var $tunnel TunnelCaveSpace */
        $tunnel = null;
        
        /* @var $cavern TunnelCaveSpace */
        $cavern = null;
        
        $this->tile = $this->selectTile($input, $output);
        
        if ($this->tile !== self::TILE_NINGUNO) {
            $pos = $this->selectPos($input, $output);
        }
        
        switch ($this->tile) {
            case self::TILE_NINGUNO:
                break;
            
            case self::TILE_TC_HORIZONTAL:
                $tunnel = new TunnelCaveSpace();
                $tunnel->setRow(3);
                $tunnel->setCol(1);
                
                $cavern = new CavernCaveSpace();
                $cavern->setRow(3);
                $cavern->setCol(2);
                break;
        }
        
        $this->actionSpace->setTunnelCaveSpace($tunnel);
        $this->actionSpace->setCavernCaveSpace($cavern);
        
//        $output->writeln($tile);        
//        var_dump($tile);
    }    
    
    protected function execute(InputInterface $input, OutputInterface $output) {
//        parent::execute($input, $output);        
    }
}
