<?php

namespace Caverna\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity;
 */
class Turn {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Round", inversedBy="turns", cascade="persist")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $round;

    /**
     * @ORM\Column(type="smallint")
     */
    private $num;
    
    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="turns", cascade="persist")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $player;
       
    /**
     * @ORM\OneToOne(targetEntity="\Caverna\CoreBundle\Entity\ActionSpace\ActionSpace")
     */
    private $actionSpace;    

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
     * @return Turn
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
     * Set round
     *
     * @param \Caverna\CoreBundle\Entity\Round $round
     *
     * @return Turn
     */
    public function setRound(\Caverna\CoreBundle\Entity\Round $round = null)
    {
        $this->round = $round;

        return $this;
    }

    /**
     * Get round
     *
     * @return \Caverna\CoreBundle\Entity\Round
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * Set player
     *
     * @param \Caverna\CoreBundle\Entity\Player $player
     *
     * @return Turn
     */
    public function setPlayer(\Caverna\CoreBundle\Entity\Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \Caverna\CoreBundle\Entity\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set actionSpace
     *
     * @param \Caverna\CoreBundle\Entity\ActionSpace\ActionSpace $actionSpace
     *
     * @return Turn
     */
    public function setActionSpace(\Caverna\CoreBundle\Entity\ActionSpace\ActionSpace $actionSpace = null)
    {
        $this->actionSpace = $actionSpace;

        return $this;
    }

    /**
     * Get actionSpace
     *
     * @return \Caverna\CoreBundle\Entity\ActionSpace\ActionSpace
     */
    public function getActionSpace()
    {
        return $this->actionSpace;
    }
}
