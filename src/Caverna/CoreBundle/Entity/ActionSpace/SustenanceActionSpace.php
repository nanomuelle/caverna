<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * @ORM\Entity;
 */
class SustenanceActionSpace extends ActionSpace {
    const KEY = 'Sustenance';
    const DESCRIPTION_1_TO_3 = "Comida: (1), Grano: +1";
    const DESCRIPTION_4_TO_7 = "Grano: 1, Hortaliza: (1)";
    
    const INITIAL_FOOD = 1;
    const GRAIN = 1;
    const REPLENISH_FOOD = 1;
    const REPLENISH_VEGETABLE = 1;
    
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
     * @param integer $amount
     */
    public function addFood($amount) {
        $this->food += $amount;
    }
    
    /**
     * @param integer $amount
     */
    public function addVegetable($amount) {
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
            return 'Comida: ' . $this->getFood() . ', Grano: ' . $this->getGrain();
        }
        return 'Grano: ' . $this->getGrain() . ', Hortaliza: ' . $this->getVegetable();
    }        
    
    public function __construct() {
        parent::__construct();
        $this->setName('Sustenance');
        $this->food = 0;
        $this->grain = 0;
        $this->vegetable = 0;
    }

    /**
     * Set food
     *
     * @param integer $food
     *
     * @return SustenanceActionSpace
     */
    public function setFood($food)
    {
        $this->food = $food;

        return $this;
    }

    /**
     * Get food
     *
     * @return integer
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * Set grain
     *
     * @param integer $grain
     *
     * @return SustenanceActionSpace
     */
    public function setGrain($grain)
    {
        $this->grain = $grain;

        return $this;
    }

    /**
     * Set vegetable
     *
     * @param integer $vegetable
     *
     * @return SustenanceActionSpace
     */
    public function setVegetable($vegetable)
    {
        $this->vegetable = $vegetable;

        return $this;
    }

    /**
     * Get vegetable
     *
     * @return integer
     */
    public function getVegetable()
    {
        return $this->vegetable;
    }
}
