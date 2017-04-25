<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
//use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\GameEngine\TileFactory;
use Caverna\CoreBundle\Entity\ActionSpace\DriftMiningActionSpace;
use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

use Caverna\CoreBundle\Entity\Player;

/**
 * @author marte
 */
class DriftMiningCommand extends ActionSpaceCommand {    
    const COMMAND_NAME = 'game:action:drift-mining';
    
    /**
     * @var string
     */
    private $selectedTileType;
    
    /**
     * @var string
     */
    private $validKeys;
    
    /**
     * @var array
     */
    private $caveSpaceByKey;
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = DriftMiningActionSpace::KEY;
        $this->selectedTileType = TileFactory::TILE_NINGUNO;
        $this->validKeys = '';
        $this->caveSpaceByKey = array();
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName(self::COMMAND_NAME)
            ->setDescription('Drift Mining')
            ;  
    }
    
    protected function getCaveRows(Player $player) {
        $rows = array(array(),array(),array(),array(),array(),array());
        
        $keys = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $contador = 0;
        /* @var $caveSpace CaveSpace */
        foreach ($player->getCaveSpaces() as $caveSpace) {
            $key = $caveSpace->acceptsTile($this->selectedTile) ? $keys[$contador] : '';
            $this->validKeys .= $key;
            
            if ($key !== '') {
                $this->caveSpaceByKey[$key] = $caveSpace;
            }
            
            $reflection = new \ReflectionClass($caveSpace);            
            $renderer = 'AppBundle\\Renderer\\' . $reflection->getShortName() . 'Renderer';
            $rows[$caveSpace->getRow()][$caveSpace->getCol()] = $renderer::render($caveSpace, $key);
            $contador++;
        }
        
        return $rows;
    }
    
    protected function selectPos(InputInterface $input, OutputInterface $output) {
        $this->renderPlayerBoard($output, $this->player);
        $question = new Question('Posicion [' . $this->validKeys . ']:');
        $question->setNormalizer(function ($answer) {
            $key = strtoupper($answer);
            if (array_key_exists($key, $this->caveSpaceByKey)) {
                return $this->caveSpaceByKey[$key];
            }
            return null;
        });
        $question->setValidator(function ($selectedCaveSpace) {
            if ($selectedCaveSpace === null) {
                throw new \RuntimeException('La posicion especificada no esta disponible.');
            }
            return $selectedCaveSpace;
        });
        $helper = $this->getHelper('question');
        return $helper->ask($input, $output, $question);
    }
    
    protected function interact(InputInterface $input, OutputInterface $output) {
        parent::interact($input, $output);
        
        $this->selectedTile = $this->selectTile($input, $output, array(
            1 => TileFactory::TILE_NINGUNO, 
            2 => TileFactory::TILE_TC_HORIZONTAL, 
            3 => TileFactory::TILE_CT_HORIZONTAL, 
            4 => TileFactory::TILE_TC_VERTICAL, 
            5 => TileFactory::TILE_CT_VERTICAL
        ));
        
        if ($this->selectedTileType === TileFactory::TILE_NINGUNO) {
            $this->actionSpace->setTile(null);
        } else {
            $caveSpace = $this->selectPos($input, $output);
            $this->actionSpace->setTile(TileFactory::createTile(
                $caveSpace->getRow(), 
                $caveSpace->getCol(), 
                $this->selectedTileType
            ));        
        }
    }    
}
