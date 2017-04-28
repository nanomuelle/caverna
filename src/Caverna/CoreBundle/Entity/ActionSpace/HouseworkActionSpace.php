<?php
namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
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
