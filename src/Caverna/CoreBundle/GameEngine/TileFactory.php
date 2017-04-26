<?php

namespace Caverna\CoreBundle\GameEngine;


use Caverna\CoreBundle\Entity\CaveSpace\CavernCaveSpace;
use Caverna\CoreBundle\Entity\CaveSpace\TunnelCaveSpace;

use Caverna\CoreBundle\Entity\ForestSpace\FieldForestSpace;
use Caverna\CoreBundle\Entity\ForestSpace\MeadowForestSpace;

/**
 * Description of TileFactory
 *
 * @author marte
 */
class TileFactory 
{
    const TILE_NINGUNO = 'Ninguno';
    
    const TILE_T = 'Tunel';
    const TILE_C = 'Caverna';    
    const TILE_TC_HORIZONTAL = 'Tunel/Caverna Horizontal';
    const TILE_CT_HORIZONTAL = 'Caverna/Tunel Horizontal';
    const TILE_CC_HORIZONTAL = 'Caverna/Caverna Horizontal';
    const TILE_TC_VERTICAL = 'Tunel/Caverna Vertical';
    const TILE_CT_VERTICAL = 'Caverna/Tunel Vertical';
    const TILE_CC_VERTICAL = 'Caverna/Caverna Vertical';
    
    const TILE_F = 'Campo';
    const TILE_M = 'Pasto';
    const TILE_FM_HORIZONTAL = 'Campo/Pasto Horizontal';
    const TILE_MF_HORIZONTAL = 'Pasto/Campo Horizontal';            
    const TILE_FM_VERTICAL = 'Campo/Pasto Vertical';
    const TILE_MF_VERTICAL = 'Pasto/Campo Vertical';
            
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
    
    private static function createHorizontalFieldMeadowTile($row, $col) {
        $field = new FieldForestSpace();
        $field->setRow($row);
        $field->setCol($col);

        $meadow = new MeadowForestSpace();
        $meadow->setRow($row);
        $meadow->setCol($col + 1);
        
        return array($field, $meadow);
    }    
    
    private static function createHorizontalMeadowFieldTile($row, $col) {
        $meadow = new MeadowForestSpace();
        $meadow->setRow($row);
        $meadow->setCol($col);
        
        $field = new FieldForestSpace();
        $field->setRow($row);
        $field->setCol($col + 1);

        return array($meadow, $field);
    }    
    
    private static function createVerticalFieldMeadowTile($row, $col) {
        $field = new FieldForestSpace();
        $field->setRow($row);
        $field->setCol($col);

        $meadow = new MeadowForestSpace();
        $meadow->setRow($row + 1);
        $meadow->setCol($col);
        
        return array($field, $meadow);
    }    
    
    private static function createVerticalMeadowFieldTile($row, $col) {
        $meadow = new MeadowForestSpace();
        $meadow->setRow($row);
        $meadow->setCol($col);
        
        $field = new FieldForestSpace();
        $field->setRow($row + 1);
        $field->setCol($col);

        return array($meadow, $field);
    }    
    
    public static function createTile($row, $col, $tileType) {
        switch ($tileType) {
            case self::TILE_NINGUNO:
                return array(null, null);

            case self::TILE_TC_HORIZONTAL:
                return self::createHorizontalTunnelCavernTile($row, $col);

            case self::TILE_CT_HORIZONTAL:
                return self::createHorizontalCavernTunnelTile($row, $col);
            
            case self::TILE_CC_HORIZONTAL:
                return self::createHorizontalCavernCavernTile($row, $col);
                    
            case self::TILE_TC_VERTICAL:
                return self::createVerticalTunnelCavernTile($row, $col);

            case self::TILE_CT_VERTICAL:
                return self::createVerticalCavernTunnelTile($row, $col);
            
            case self::TILE_CC_VERTICAL:
                return self::createVerticalCavernCavernTile($row, $col);
                
            case self::TILE_FM_HORIZONTAL:
                return self::createHorizontalFieldMeadowTile($row, $col);
            
            case self::TILE_MF_HORIZONTAL:
                return self::createHorizontalMeadowFieldTile($row, $col);
                
            case self::TILE_FM_VERTICAL:
                return self::createVerticalFieldMeadowTile($row, $col);
            
            case self::TILE_MF_VERTICAL:
                return self::createVerticalMeadowFieldTile($row, $col);                
        }        
    }

}
