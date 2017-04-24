<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

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
    const COMMAND_NAME = 'game:action:drift-mining';
    
    /**
     * @var string
     */
    private $selectedTile;
    
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
        $this->selectedTile = GameEngine::TILE_NINGUNO;
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
    
    protected function selectTile(InputInterface $input, OutputInterface $output) {
        $helper = $this->getHelper('question');
        
        $tiles = array(
            1 => GameEngine::TILE_NINGUNO, 
            2 => GameEngine::TILE_TC_HORIZONTAL, 
            3 => GameEngine::TILE_CT_HORIZONTAL, 
            4 => GameEngine::TILE_TC_VERTICAL, 
            5 => GameEngine::TILE_CT_VERTICAL
        );
        
        $question = new ChoiceQuestion('Selecciona la loseta que quieres:', $tiles, 0);
        $question->getAutocompleterValues($tiles);
        $question->setErrorMessage('La loseta %s no es valida.');
        $selectedTile = $helper->ask($input, $output, $question);
        
        return $selectedTile;
    }
    
    protected function getCaveRows(Player $player) {
        $rows = array(array(),array(),array(),array(),array(),array());
        
        $keys = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $contador = 0;
        /* @var $caveSpace CaveSpace */
        foreach ($player->getCaveSpaces() as $caveSpace) {
            $key = $caveSpace->acceptsTile($this->selectedTile) ? $keys[$contador] : '';
            $this->validKeys .= $key;
            $this->caveSpaceByKey[$key] = $caveSpace;
            
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
        
        $this->selectedTile = $this->selectTile($input, $output);
        if ($this->selectedTile !== GameEngine::TILE_NINGUNO) {
            $caveSpace = $this->selectPos($input, $output);
        }

        $cavern = new CavernCaveSpace();
        $tunnel = new TunnelCaveSpace();
            
        switch ($this->selectedTile) {
            case GameEngine::TILE_NINGUNO:
                $tunnel = null;
                $cavern = null;
                break;

            case GameEngine::TILE_TC_HORIZONTAL:
                $tunnel->setRow($caveSpace->getRow());
                $tunnel->setCol($caveSpace->getCol());

                $cavern->setRow($caveSpace->getRow());
                $cavern->setCol($caveSpace->getCol() + 1);
                break;

            case GameEngine::TILE_CT_HORIZONTAL:
                $cavern->setRow($caveSpace->getRow());
                $cavern->setCol($caveSpace->getCol());

                $tunnel->setRow($caveSpace->getRow());
                $tunnel->setCol($caveSpace->getCol() + 1);
                break;

            case GameEngine::TILE_TC_VERTICAL:
                $tunnel->setRow($caveSpace->getRow());
                $tunnel->setCol($caveSpace->getCol());

                $cavern->setRow($caveSpace->getRow() + 1);
                $cavern->setCol($caveSpace->getCol());
                break;

            case GameEngine::TILE_CT_VERTICAL:
                $cavern->setRow($caveSpace->getRow());
                $cavern->setCol($caveSpace->getCol());

                $tunnel->setRow($caveSpace->getRow() + 1);
                $tunnel->setCol($caveSpace->getCol());
                break;
        }
        
        $this->actionSpace->setTunnelCaveSpace($tunnel);
        $this->actionSpace->setCavernCaveSpace($cavern);
    }    
}
