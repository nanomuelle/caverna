<?php

namespace Caverna\CoreBundle\GameEngine;

/**
 * Description of TileFactory
 *
 * @author marte
 */
class TileFactory {
    const TILE_NINGUNO = 'Ninguno';
    const TILE_T = 'Tunel';
    const TILE_C = 'Caverna';
    const TILE_TC_HORIZONTAL = 'Tunel/Caverna Horizontal';
    const TILE_CT_HORIZONTAL = 'Caverna/Tunel Horizontal';
    const TILE_CC_HORIZONTAL = 'Caverna/Caverna Horizontal';
    const TILE_TC_VERTICAL = 'Tunel/Caverna Vertical';
    const TILE_CT_VERTICAL = 'Caverna/Tunel Vertical';
    const TILE_CC_VERTICAL = 'Caverna/Caverna Vertical';
            
    private static function createHorizontalTunnelCavernTile($row, $col) {
        $tunnel = new TunnelCaveSpace();
        $tunnel->setRow($row);
        $tunnel->setCol($col);

        $cavern = new CavernCaveSpace();
        $cavern->setRow($row);
        $cavern->setCol($col + 1);
        
        return array($tunnel, $cavern);
    }    
    
    private static function createHorizontalCavernTunnelTile($row, $col) {
        $cavern = new CavernCaveSpace();
        $cavern->setRow($row);
        $cavern->setCol($col);
        
        $tunnel = new TunnelCaveSpace();
        $tunnel->setRow($row);
        $tunnel->setCol($col + 1);
        
        return array($cavern, $tunnel);
    }

    private static function createHorizontalCavernCavernTile($row, $col) {
        $cavern1 = new CavernCaveSpace();
        $cavern1->setRow($row);
        $cavern1->setCol($col);
        
        $cavern2 = new CavernCaveSpace();
        $cavern2->setRow($row);
        $cavern2->setCol($col + 1);
        
        return array($cavern1, $cavern2);
    }
    
    private static function createVerticalTunnelCavernTile($row, $col) {
        $tunnel = new TunnelCaveSpace();
        $tunnel->setRow($row);
        $tunnel->setCol($col);
        
        $cavern = new CavernCaveSpace();
        $cavern->setRow($row + 1);
        $cavern->setCol($col);
        
        return array($tunnel, $cavern);
    }
    
    private static function createVerticalCavernTunnelTile($row, $col) {
        $cavern = new CavernCaveSpace();
        $cavern->setRow($row);
        $cavern->setCol($col);

        $tunnel = new TunnelCaveSpace();
        $tunnel->setRow($row + 1);
        $tunnel->setCol($col);
        
        return array($cavern, $tunnel);
    }

    private static function createVerticalCavernCavernTile($row, $col) {
        $cavern1 = new CavernCaveSpace();
        $cavern1->setRow($row);
        $cavern1->setCol($col);
        
        $cavern2 = new CavernCaveSpace();
        $cavern2->setRow($row + 1);
        $cavern2->setCol($col);

        return array($cavern1, $cavern2);
    }
    
    public static function createTile($row, $col, $tileType) {
        switch ($tileType) {
            case GameEngine::TILE_NINGUNO:
                return array(null, null);

            case GameEngine::TILE_TC_HORIZONTAL:
                return self::createHorizontalTunnelCavernTile($row, $col);

            case GameEngine::TILE_CT_HORIZONTAL:
                return self::createHorizontalCavernTunnelTile($row, $col);
            
            case GameEngine::TILE_CC_HORIZONTAL:
                return self::createHorizontalCavernCavernTile($row, $col);
                    
            case GameEngine::TILE_TC_VERTICAL:
                return self::createVerticalTunnelCavernTile($row, $col);

            case GameEngine::TILE_CT_VERTICAL:
                return self::createVerticalCavernTunnelTile($row, $col);
            
            case GameEngine::TILE_CC_VERTICAL:
                return self::createVerticalCavernCavernTile($row, $col);
        }        
    }

}
