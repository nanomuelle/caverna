<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Caverna\CoreBundle\GameEngine\Action;

/**
 * Description of PlaceMeadowFieldTwinTile
 *
 * @author marte
 */
class PlaceMeadowFieldTwinTile {
    public static function execute(Player $player, $tile) {
        if ($tile !== null) {
            $player->placeForestSpace($tile[0]);
            $player->placeForestSpace($tile[1]);
        }                  
    }
}
