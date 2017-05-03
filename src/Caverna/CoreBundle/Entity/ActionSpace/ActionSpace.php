<?php

namespace Caverna\CoreBundle\Entity\ActionSpace;

use Doctrine\ORM\Mapping as ORM;

use Caverna\CoreBundle\Entity\Player;
use Caverna\CoreBundle\Entity\Game;

/**
 * @ORM\Entity;
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *      "DriftMining" = "DriftMiningActionSpace",
 *      "Imitation" = "ImitationActionSpace",
 *      "Logging" = "LoggingActionSpace",
 *      "ForestExploration" = "ForestExplorationActionSpace",
 *      "Excavation" = "ExcavationActionSpace",
 *      "Growth" = "GrowthActionSpace",
 *      "Clearing" = "ClearingActionSpace",
 *      "StartingPlayer" = "StartingPlayerActionSpace",
 *      "OreMining" = "OreMiningActionSpace",
 *      "Sustenance" = "SustenanceActionSpace",
 *      "RubyMining" = "RubyMiningActionSpace",
 *      "Housework" = "HouseworkActionSpace",
 *      "SlashAndBurn" = "SlashAndBurnActionSpace"
 * })
 */
abstract class ActionSpace {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="\Caverna\CoreBundle\Entity\Game", inversedBy="actionSpaces", cascade="persist")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $game;

    /**
     * @ORM\OneToOne(targetEntity="\Caverna\CoreBundle\Entity\Dwarf")
     * @ORM\JoinColumn(name="dwarf_id", nullable=true, onDelete="SET NULL")
     */
    private $dwarf;

    /**
     * @ORM\Column(type="smallint")
     */
    private $availableFromRoundNum;
    
    /**
     * @ORM\Column(type="smallint")
     */
    private $num;
    
    /**
     * @return string key
     */
    public abstract function getKey();
    
    /**
     * @return string description
     */
    public abstract function getDescription();
    
    public abstract function getState();
    
    public function replenish() {
        return;
    } 
        
    public function isAvailable() {        
        // partida no jugando
        if ($this->getGame()->getStatus() !== Game::STATUS_PLAYING ) {
            return false;
        }
            
        // ocupado por un enano
        if ($this->getDwarf() !== null) {
            return false;
        }
        
        // ronda aun no disponible
        if ($this->getGame()->getCurrentRound()->getNum() < $this->getAvailableFromRoundNum()) {
            return false;
        }
        
        return true;
    }
    
    /**
     * 
     * @param Player $player
     * @return boolean
     */
    public function isImitableForPlayer(Player $player) {
        if ($this->isAvailable()) {
            return false;
        }
        
        if ($this->getDwarf()->getPlayer() == $player) {
            return false;
        }
        
        return true;
    }
    
    public function __toString() {
        return $this->name;
    }
    
    /**
     * Set dwarf
     *
     * @param \Caverna\CoreBundle\Entity\Dwarf $dwarf
     *
     * @return ActionSpace
     */
    public function setDwarf(\Caverna\CoreBundle\Entity\Dwarf $dwarf = null)
    {
        $this->dwarf = $dwarf;
        
        if ($dwarf !== null) {
            $dwarf->setActionSpace($this);
        }
        return $this;
    }
    
    public function __construct() {
//        $this->wood = 0;
//        $this->stone = 0;
//        $this->ore = 0;
//        $this->ruby = 0;
//        $this->food = 0;
//        $this->grain = 0;
//        $this->vegetable = 0;
//        $this->dog = 0;
//        $this->sheep = 0;
//        $this->boar = 0;
//        $this->cow = 0;
//        $this->victoryPoints = 0;
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
     * Set name
     *
     * @param string $name
     *
     * @return ActionSpace
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set num
     *
     * @param integer $num
     *
     * @return ActionSpace
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return integer
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set game
     *
     * @param \Caverna\CoreBundle\Entity\Game $game
     *
     * @return ActionSpace
     */
    public function setGame(\Caverna\CoreBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \Caverna\CoreBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Get dwarf
     *
     * @return \Caverna\CoreBundle\Entity\Dwarf
     */
    public function getDwarf()
    {
        return $this->dwarf;
    }

    /**
     * Set availableFromRoundNum
     *
     * @param integer $availableFromRoundNum
     *
     * @return ActionSpace
     */
    public function setAvailableFromRoundNum($availableFromRoundNum)
    {
        $this->availableFromRoundNum = $availableFromRoundNum;

        return $this;
    }

    /**
     * Get availableFromRoundNum
     *
     * @return integer
     */
    public function getAvailableFromRoundNum()
    {
        return $this->availableFromRoundNum;
    }
}
