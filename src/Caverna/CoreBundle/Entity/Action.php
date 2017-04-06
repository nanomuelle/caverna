<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Caverna\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity;
 */
class Action {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $actionKey;

    /**
     * @ORM\ManyToOne(targetEntity="Game")
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player;

    /**
     * @ORM\ManyToOne(targetEntity="Dwarf")
     * @ORM\JoinColumn(name="dwarf_id", nullable=true, onDelete="SET NULL")     
     */
    private $dwarf;

    /**
     * @ORM\Column(type="string")
     */
    private $params;

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
     * Set actionKey
     *
     * @param string $actionKey
     *
     * @return Action
     */
    public function setActionKey($actionKey)
    {
        $this->actionKey = $actionKey;

        return $this;
    }

    /**
     * Get actionKey
     *
     * @return string
     */
    public function getActionKey()
    {
        return $this->actionKey;
    }

    /**
     * Set params
     *
     * @param string $params
     *
     * @return Action
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Get params
     *
     * @return string
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set game
     *
     * @param \Caverna\CoreBundle\Entity\Game $game
     *
     * @return Action
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
     * Set player
     *
     * @param \Caverna\CoreBundle\Entity\Player $player
     *
     * @return Action
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
     * Set dwarf
     *
     * @param \Caverna\CoreBundle\Entity\Dwarf $dwarf
     *
     * @return Action
     */
    public function setDwarf(\Caverna\CoreBundle\Entity\Dwarf $dwarf = null)
    {
        $this->dwarf = $dwarf;

        return $this;
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
}
