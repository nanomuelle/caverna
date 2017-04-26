<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\GameEngine\TileFactory;

use Caverna\CoreBundle\Entity\Player;
use Caverna\CoreBundle\Entity\ActionSpace\DriftMiningActionSpace;

/**
 * @author marte
 */
class DriftMiningCommand extends ActionSpaceCommand {    
    const COMMAND_NAME = 'game:action:drift-mining';
    
    private $positions;
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = DriftMiningActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName(self::COMMAND_NAME)
            ->setDescription('Drift Mining')
            ;  
    }
    
    private function getCaveSpaceKey($row, $col) {
        foreach ($this->positions as $key => $position) {
            if ($position->getRow() === $row && $position->getCol() === $col) {
                return $key;
            }
        }
        return '';
    }

    protected function getCaveRows(Player $player) {
        $rows = array(array(),array(),array(),array(),array(),array());
        
        foreach ($player->getCaveSpaces() as $caveSpace) {
            $row = $caveSpace->getRow();
            $col = $caveSpace->getCol();
            
            $key = $this->getCaveSpaceKey($row, $col);  
            
            $reflection = new \ReflectionClass($caveSpace);            
            $renderer = 'AppBundle\\Renderer\\' . $reflection->getShortName() . 'Renderer';
            
            $rows[$row][$col] = $renderer::render($caveSpace, $key);
        }
        
        return $rows;
    }
    
    protected function interact(InputInterface $input, OutputInterface $output) {
        parent::interact($input, $output);
        
        $tileType = $this->selectTileType($input, $output, $this->actionSpace->getTileTypes());        
        if ($tileType === TileFactory::TILE_NINGUNO) {
            $this->actionSpace->setTile(null);
            return;
        }
        
        $this->positions = $this->player->validCaveSpacesForTileType($tileType);
        $position = $this->selectTilePosition($input, $output, $this->positions);
        $this->actionSpace->setTile(TileFactory::createTile(
            $position->getRow(), 
            $position->getCol(), 
            $tileType
        ));                
    }    
}