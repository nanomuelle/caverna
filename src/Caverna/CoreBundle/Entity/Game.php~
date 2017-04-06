<?php

namespace Caverna\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;
// use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 */
class Game
{
    const STATUS_WAITING_PLAYERS = 'STATUS_WAITING_PLAYERS';
    const STATUS_READY = 'STATUS_READY';
    const STATUS_PLAYING = 'STATUS_PLAYING';
    const STATUS_FINISHED = 'STATUS_FINISHED';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

     /**
      * @ORM\OneToMany(targetEntity="Player", mappedBy="game", cascade={"persist"})
      * @ORM\OrderBy({"num" = "ASC"})
      */
     private $players;

     /**
      * @ORM\OneToMany(targetEntity="Round", mappedBy="game", cascade={"persist"})
      */
     private $rounds;

     /**
      * @ORM\OneToOne(targetEntity="Round")
      * @ORM\JoinColumn(name="currentRound_id", nullable=true, onDelete="SET NULL")
      */
     private $currentRound;

     /**
      * @ORM\Column(type="smallint")
      */
     private $numRedHarvestMarkers;
     
     /**
      * @ORM\Column(type="string")
      */
     private $status;

     /**
      * @ORM\OneToMany(targetEntity="\Caverna\CoreBundle\Entity\ActionSpace\ActionSpace", mappedBy="game")
      * @ORM\OrderBy({"num" = "ASC"})
      */
     private $actionSpaces;
     
     public function getImitableActionSpacesForPlayer(Player $player) {
         $imitableActionSpaces = new ArrayCollection();
         foreach ($this->actionSpaces as $actionSpace) {
             if ($actionSpace->isImitableForPlayer($player)) {
                 $imitableActionSpaces[] = $actionSpace;
             }
         }
         return $imitableActionSpaces;
     }
     /**
      * Add round
      *
      * @param \Caverna\CoreBundle\Entity\Round $round
      *
      * @return Game
      */
     public function addRound(\Caverna\CoreBundle\Entity\Round $round)
     {
         $round->setGame($this);
         $this->rounds[] = $round;
         
         if ($this->rounds->count() === 1) {
             $this->setCurrentRound($round);
         }
         
         return $this;
     }
     
    /**
     * Add actionSpace
     *
     * @param \Caverna\CoreBundle\Entity\ActionSpace\ActionSpace $actionSpace
     *
     * @return Game
     */
    public function addActionSpace(\Caverna\CoreBundle\Entity\ActionSpace\ActionSpace $actionSpace)
    {
        $actionSpace->setGame($this);
        $this->actionSpaces[] = $actionSpace;

        return $this;
    }

     /**
      * Add player
      *
      * @param \Caverna\CoreBundle\Entity\Player $player
      *
      * @return Game
      */
     public function addPlayer(\Caverna\CoreBundle\Entity\Player $player)
     {
         if ($this->players->count() > 0) {
            $this->players->last()->setNext($player);
         }
         
         $player->setGame($this);
         $this->players[] = $player;

         if ($this->players->count() === $this->getNumPlayers()) {
             $player->setNext($this->players->first());
             $this->status = Game::STATUS_READY;
         } 
                  
         return $this;
     }

     public function getNumPlayers()
     {
         return $this->players->count();
     }

     /**
      * 
      * @param type $key
      * @return Caverna\CoreBundle\Entity\ActionSpace\ActionSpace
      */
     public function getActionSpaceByKey($key) {
         foreach ($this->actionSpaces as $actionSpace) {
             if ($actionSpace->getKey() === $key) {
                 return $actionSpace;
             }             
         }
        return null;
    }
     public function __construct() {
         $this->numRedHarvestMarkers = 0;
         $this->status = Game::STATUS_WAITING_PLAYERS;

         $this->rounds = new ArrayCollection();
         $this->players = new ArrayCollection();

         $this->createdAt = new \DateTime();
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Game
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set numRedHarvestMarkers
     *
     * @param integer $numRedHarvestMarkers
     *
     * @return Game
     */
    public function setNumRedHarvestMarkers($numRedHarvestMarkers)
    {
        $this->numRedHarvestMarkers = $numRedHarvestMarkers;

        return $this;
    }

    /**
     * Get numRedHarvestMarkers
     *
     * @return integer
     */
    public function getNumRedHarvestMarkers()
    {
        return $this->numRedHarvestMarkers;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Game
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Remove player
     *
     * @param \Caverna\CoreBundle\Entity\Player $player
     */
    public function removePlayer(\Caverna\CoreBundle\Entity\Player $player)
    {
        $this->players->removeElement($player);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Remove round
     *
     * @param \Caverna\CoreBundle\Entity\Round $round
     */
    public function removeRound(\Caverna\CoreBundle\Entity\Round $round)
    {
        $this->rounds->removeElement($round);
    }

    /**
     * Get rounds
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRounds()
    {
        return $this->rounds;
    }

    /**
     * Set currentRound
     *
     * @param \Caverna\CoreBundle\Entity\Round $currentRound
     *
     * @return Game
     */
    public function setCurrentRound(\Caverna\CoreBundle\Entity\Round $currentRound = null)
    {
        $this->currentRound = $currentRound;

        return $this;
    }

    /**
     * Get currentRound
     *
     * @return \Caverna\CoreBundle\Entity\Round
     */
    public function getCurrentRound()
    {
        return $this->currentRound;
    }

    /**
     * Remove actionSpace
     *
     * @param \Caverna\CoreBundle\Entity\ActionSpace\ActionSpace $actionSpace
     */
    public function removeActionSpace(\Caverna\CoreBundle\Entity\ActionSpace\ActionSpace $actionSpace)
    {
        $this->actionSpaces->removeElement($actionSpace);
    }

    /**
     * Get actionSpaces
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActionSpaces()
    {
        return $this->actionSpaces;
    }
}
