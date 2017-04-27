<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

use Caverna\CoreBundle\GameEngine\TileFactory;

use Caverna\CoreBundle\Entity\Player;

/**
 * @author marte
 */
abstract class TwinForestTileCommandBase extends ActionSpaceCommand 
{
    protected $positions;
    
    private function getForestSpaceKey($row, $col) {
        foreach ($this->positions as $key => $position) {
            if ($position->getRow() === $row && $position->getCol() === $col) {
                return $key;
            }
        }
        return '';
    }
    
    protected function getForestRows(Player $player) {
        $rows = array(array(),array(),array(),array(),array(),array());
        
        foreach ($player->getForestSpaces() as $forestSpace) {
            $row = $forestSpace->getRow();
            $col = $forestSpace->getCol();
            
            $key = $this->getForestSpaceKey($row, $col);  
            
            $reflection = new \ReflectionClass($forestSpace);
            $renderer = 'AppBundle\\Renderer\\' . $reflection->getShortName() . 'Renderer';            
            $rows[$row][$col] = $renderer::render($forestSpace, $key);
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
        
        $this->positions = $this->player->validForestSpacesForTileType($tileType);
        $position = $this->selectTilePosition($input, $output, $this->positions);
        $this->actionSpace->setTile(TileFactory::createTile(
            $position->getRow(), 
            $position->getCol(), 
            $tileType
        ));                
    }    
}