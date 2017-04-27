<?php

namespace AppBundle\Renderer;

/**
 * Description of SpaceRenderer
 *
 * @author marte
 */
class SpaceRenderer {    
    // Common
    const RIVER = '<bg=cyan> </>';
    const FOOD_PLUS = '<bg=cyan;fg=blue>+</>';
    const FOOD_1 = '<bg=cyan;fg=blue>1</>';
    const FOOD_2 = '<bg=cyan;fg=blue>2</>';
    
    // Corners
    const UPPER_LEFT_CORNER = "\xDA";   // chr(218); ┌
    const UPPER_RIGHT_CORNER =  "\xBF"; // chr(191); ┐
    const BOTTOM_LEFT_CORNER = "\xC0";  // chr(192); └    
    const BOTTOM_RIGHT_CORNER = "\xD9"; // chr(217); ┘
    
    // Forest
    const FOREST = "<bg=green;fg=yellow>\xB1</>"; // ░ = \xB0 = chr(177)
    const EXTERNAL_FOREST = "<bg=green;fg=black>\xB2</>"; // ▓ = \xB2 = chr(178)
    const BOAR_REWARD = '<bg=white;fg=red>B</>';
    const INITIAL_FOREST = '<bg=green;fg=yellow;options=bold><</>';
    
    // Mountain
    const EXTERNAL_MOUNTAIN = "<bg=green;fg=black>\xB2</>"; // ▓ = \xB2 = chr(178)
    const INTERNAL_MOUNTAIN = "<bg=cyan;fg=black>\xB1</>"; // ▒ = \xB1 = chr(177)    
    const MIDDLE_MOUNTAIN = "<bg=cyan;fg=blue>\xB2</>"; // ▓ = \XB2 = char(178)
    
    // Cavern
    const CAVERN = "<bg=blue;fg=cyan> </>";
    const CAVERN_UPPER_LEFT = "<bg=blue;fg=cyan>\xDA</>";
    const CAVERN_UPPER_RIGHT = "<bg=blue;fg=cyan>\xBF</>";
    const CAVERN_BOTTOM_LEFT = "<bg=blue;fg=cyan>\xC0</>";
    const CAVERN_BOTTOM_RIGHT = "<bg=blue;fg=cyan>\xD9</>";
    
    // Tunnel
    const TUNNEL = "<bg=blue;fg=cyan>\xB0</>";
    const TUNNEL_CORNER = "<bg=cyan;fg=cyan>\xB1</>"; // ▒ = \xB1 = chr(177)
    const TUNNEL_UPPER_LEFT = "<bg=blue;fg=cyan>\xD9</>";
    const TUNNEL_UPPER_RIGHT = "<bg=blue;fg=cyan>\xC0</>";
    const TUNNEL_BOTTOM_LEFT = "<bg=blue;fg=cyan>\xBF</>";
    const TUNNEL_BOTTOM_RIGHT = "<bg=blue;fg=cyan>\xDA</>";    
    
    // Field
    const FIELD = "<bg=white;fg=green>\xB2</>"; // ▓ = \xB2 = chr(178)
    
    // Meadow
    const MEADOW = "<bg=green;fg=black>\xBA</>"; // ║ = \xBA = chr(186)
    
    // Dwelling
    const DWELLING = "<bg=white;fg=black> </>";
    
    public static function render(
        $p11, $p12, $p13,
        $p21, $p22, $p23,
        $p31, $p32, $p33, 
        $key = '') {
        
        if ($key === '') {
            return sprintf("%s%s%s\n%s%s%s\n%s%s%s", $p11, $p12,$p13, $p21,$p22, $p23, $p31, $p32, $p33);
        }
        $k = self::formatKey($key);
        return sprintf("%s%s%s\n%s%s%s\n%s%s%s", $p11, $p12,$p13, $p21, $k, $p23, $p31, $p32, $p33);
    }
    
    public static function dwellingHeader($c = ' ') {
        return sprintf("<bg=yellow;fg=black>%s</>", $c);
    }
    
    private static function formatKey($key) {
        return '<bg=black;fg=white;options=bold>' . $key . '</>';  // key
    }
}
