<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * @ORM\Entity;
 */
class SustenanceActionSpace extends ActionSpace {
    const KEY = 'Sustenance';
    const DESCRIPTION_1_TO_3 = "Food: (1) Grain: +1";
    const DESCRIPTION_4_TO_7 = "Grain: 1 Vegetable: (1)";
    
    const INITIAL_FOOD = 1;
    const GRAIN = 1;
    const REPLENISH_FOOD = 1;
    const REPLENISH_VEGETABLE = 1;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $food;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $grain;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $vegetable;
    
    private function oneToTreePlayers() {
        return $this->getGame()->getNumPlayers() < 4;
    }
    
    public function getGrain() {
        if ($this->oneToTreePlayers()) {
            return self::GRAIN;
        }
        
        return $this->grain;
    }
    
    /**
     * @param integer $amoung
     */
    public function addFood($amoung) {
        $this->food += $amount;
    }
    
    /**
     * @param integer $amoung
     */
    public function addVegetable($amoung) {
        $this->vegetable += $amount;
    }
    
    public function getKey() {
        return self::KEY;
    }
    
    public function getDescription() {
        if ($this->oneToTreePlayers()) {
            return self::DESCRIPTION_1_TO_3;
        }
        
        return self::DESCRIPTION_4_TO_7;
    }
    
    public function getState() {
        if ($this->oneToTreePlayers()) {
            return 'Comida: ' . $this->getFood() . "\n" . ' Grano: ' . $this->getGrain();
        }
    }        
    
    public function __toString() {        
        if ($this->oneToTreePlayers()) {
            return parent::__toString() . 'F: ' . $this->getFood() . ' G: ' . $this->getGrain();
        }
        
        return parent::__toString() . 'G: ' . $this->getGrain() . ' H: ' . $this->getVegetable();        
    }
    
    public function __construct() {
        parent::__construct();
        $this->setName('Sustenance');
        $this->food = 0;
        $this->grain = 0;
        $this->vegetable = 0;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set wood
     *
     * @param integer $wood
     *
     * @return LoggingActionSpace
     */
    public function setWood($wood)
    {
        $this->wood = $wood;

        return $this;
    }

    /**
     * Get wood
     *
     * @return integer
     */
    public function getWood()
    {
        return $this->wood;
    }
}
