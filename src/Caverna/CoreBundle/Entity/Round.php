<?php

namespace Caverna\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity;
 */
class Round {
    const HARVEST_NO = 'HARVEST_NO';
    const HARVEST_FEEDING = 'HARVEST_FEEDING';
    const HARVEST_RED = 'HARVEST_RED';
    const HARVEST_GREEN = 'HARVEST_GREEN';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="rounds", cascade="persist")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $game;
    
    /**
     * @ORM\Column(type="smallint")
     */
    private $num;

    /**
     * @ORM\Column(type="smallint")
     */
    private $stage;

    /**
     * @ORM\Column(type="string")
     */
    private $harvestMarker;

    /**
     * @ORM\ManyToOne(targetEntity="Player")
     * @ORM\JoinColumn(name="initialPlayer_id")
     */
    private $initialPlayer;

    /**
     * @ORM\OneToOne(targetEntity="Turn")
     */
    private $currentTurn;
    
    /**
     * @ORM\OneToMany(targetEntity="Turn", mappedBy="round", cascade={"persist"})
     */
    private $turns;    

    /**
     * Try to finish current tur
     * 
     * @return boolean
     */
    public function finishCurrentTurn() {
        // Si no hay turno actual no hacemos nada
        if ($this->getCurrentTurn() === null) {
            throw new Exception('No hay turno actual');
//            return false;
        }
        
        // Si no se ha jugado un enano a un actionSpace, no se puede finalizar el turno
        if ($this->getCurrentTurn()->getActionSpace() === null) {
            throw new \Exception('El jugador actual aun no ha realizado ninguna accion');
//            return false;
        }
        
        $nextNumTurn = $this->getCurrentTurn()->getNum() + 1;
        foreach ($this->getTurns() as $turn) {
            if ($turn->getNum() === $nextNumTurn) {
                $this->setCurrentTurn($turn);
                return;
            }
        }
        
        // no hay mas turnos
        $this->setCurrentTurn(null);
    }
    
    /**
     * Add turn
     *
     * @param \Caverna\CoreBundle\Entity\Turn $turn
     *
     * @return Round
     */
    public function addTurn(\Caverna\CoreBundle\Entity\Turn $turn)
    {
        $turn->setRound($this);        
        $this->turns[] = $turn;
        
        if ($this->turns->count() === 1) {
            $this->currentTurn = $turn;
        }

        return $this;
    }

    
    public function __construct() {
        $this->turns = new ArrayCollection();
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
     * Set num
     *
     * @param integer $num
     *
     * @return Round
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
     * Set stage
     *
     * @param integer $stage
     *
     * @return Round
     */
    public function setStage($stage)
    {
        $this->stage = $stage;

        return $this;
    }

    /**
     * Get stage
     *
     * @return integer
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * Set harvestMarker
     *
     * @param string $harvestMarker
     *
     * @return Round
     */
    public function setHarvestMarker($harvestMarker)
    {
        $this->harvestMarker = $harvestMarker;

        return $this;
    }

    /**
     * Get harvestMarker
     *
     * @return string
     */
    public function getHarvestMarker()
    {
        return $this->harvestMarker;
    }

    /**
     * Set game
     *
     * @param \Caverna\CoreBundle\Entity\Game $game
     *
     * @return Round
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
     * Set initialPlayer
     *
     * @param \Caverna\CoreBundle\Entity\Player $initialPlayer
     *
     * @return Round
     */
    public function setInitialPlayer(\Caverna\CoreBundle\Entity\Player $initialPlayer = null)
    {
        $this->initialPlayer = $initialPlayer;

        return $this;
    }

    /**
     * Get initialPlayer
     *
     * @return \Caverna\CoreBundle\Entity\Player
     */
    public function getInitialPlayer()
    {
        return $this->initialPlayer;
    }

    /**
     * Set currentTurn
     *
     * @param \Caverna\CoreBundle\Entity\Turn $currentTurn
     *
     * @return Round
     */
    public function setCurrentTurn(\Caverna\CoreBundle\Entity\Turn $currentTurn = null)
    {
        $this->currentTurn = $currentTurn;

        return $this;
    }

    /**
     * Get currentTurn
     *
     * @return \Caverna\CoreBundle\Entity\Turn
     */
    public function getCurrentTurn()
    {
        return $this->currentTurn;
    }

    /**
     * Remove turn
     *
     * @param \Caverna\CoreBundle\Entity\Turn $turn
     */
    public function removeTurn(\Caverna\CoreBundle\Entity\Turn $turn)
    {
        $this->turns->removeElement($turn);
    }

    /**
     * Get turns
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTurns()
    {
        return $this->turns;
    }
}
