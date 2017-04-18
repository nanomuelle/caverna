<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

use Symfony\Component\Console\Helper\Table;
// use Symfony\Component\Console\Helper\TableStyle;

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
    
    private function getCaveRows(Player $player) {
        $rows = array(array(),array(),array(),array(),array(),array());
        
        $keys = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        /* @var $caveSpace CaveSpace */
        $contador = 0;
        foreach ($player->getCaveSpaces() as $caveSpace) {
//            $rows[$caveSpace->getRow()][$caveSpace->getCol()] = $caveSpace;
                        
            $reflection = new \ReflectionClass($caveSpace);            
            $renderer = 'AppBundle\\Renderer\\' . $reflection->getShortName() . 'Renderer';
            if (class_exists($renderer)) {
                $out = $renderer::render($caveSpace, $keys[$contador]);
            } else {
                $out = $keys[$contador] . substr('' . $caveSpace, 1);
            }
            $rows[$caveSpace->getRow()][$caveSpace->getCol()] = $out;
            $contador++;
        }
        
        return $rows;
    }
    
    protected function selectPos(InputInterface $input, OutputInterface $output) {
        $rows = $this->getCaveRows($this->player);
        
        $table = new Table($output);
        $table->setStyle('compact');
//        $table->setStyle($style);
        $table->addRows($rows);
        $table->render();
    }
    
    protected function interact(InputInterface $input, OutputInterface $output) {
        parent::interact($input, $output);
        
        /* @var $tunnel TunnelCaveSpace */
        $tunnel = null;
        
        /* @var $cavern TunnelCaveSpace */
        $cavern = null;
        
        $tile = $this->selectTile($input, $output);
        
        if ($tile !== self::TILE_NINGUNO) {
            $pos = $this->selectPos($input, $output);
        }
        
        switch ($tile) {
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
