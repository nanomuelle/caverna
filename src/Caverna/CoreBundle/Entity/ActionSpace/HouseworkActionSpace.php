<?php
namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * Housework: Take 1 Dog from the general supply. Additionally or alternatively, 
 * take a Furnishing tile, pay its building costs and place it on an empty 
 * Cavern in your cave system. You may choose from all Furnishing tiles 
 * (including Dwellings). If you cannot place a Furnishing tile on your Home 
 * board, you may not take any. (This is an “and/or” Action space; you may carry 
 * out the actions in either order. For instance, you might want to take the Dog 
 * after building the “Dog school”.)
 *
 * @ORM\Entity;
 */
class HouseworkActionSpace extends ActionSpace
{
    const KEY = "Housework";
    
    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {
        return 'Perro: 1, Furnish cavern';
    }
    
    public function getState() {
        return 'Perro: 1, Furnish cavern';
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Housework');
    }    
}
