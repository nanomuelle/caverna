<?php

namespace Caverna\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Caverna\CoreBundle\GameEngine\Dwelling\SpaceForDwarfsInterface;

/**
 * @ORM\Entity
 */
class Player
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="players")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $game;

    /**
     * @ORM\Column(type="string")
     */
    private $color;

    /**
     * @ORM\Column(type="smallint")
     */
    private $num;
    
    /**
     * @ORM\OneToMany(targetEntity="Dwarf", mappedBy="player", cascade={"persist"})
     */
    private $dwarfs;

    /**
     * @ORM\OneToMany(targetEntity="\Caverna\CoreBundle\Entity\ForestSpace\BaseForestSpace", mappedBy="player", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"row" = "ASC", "col" = "ASC"})
     */
    private $forestSpaces;
    
    /**
     * @ORM\OneToMany(targetEntity="\Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace", mappedBy="player", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"row" = "ASC", "col" = "ASC"})
     */
    private $caveSpaces;
    
    /**
     * @ORM\OneToOne(targetEntity="Player")
     */
    private $next;
    
    /**
     * @ORM\Column(type="smallint")
     */
    private $food;
    
    /**
     * @ORM\Column(type="smallint")
     */
    private $wood;
    
    /**
     * @ORM\Column(type="smallint")
     */
    private $stone;
    
     /**
     * @ORM\Column(type="smallint")
     */
    private $ore;
    
     /**
     * @ORM\Column(type="smallint")
     */
    private $ruby;
    
    /**
     * @ORM\Column(type="smallint")
     */
    private $vp;
    
    /**
     *
     * @ORM\Column(type="smallint")
     */
    private $grain;
    
    /**
     * @ORM\Column(type="smallint")
     */
    private $vegetable;
    
    /**
     * @param integer $amount
     */
    public function addFood($amount) {
        $this->food += $amount;
    }
    
    /**
     * @param integer $amount
     */
    public function addWood($amount) {
        $this->wood += $amount;
    }
    
    /**
     * @param integer $amount
     */
    public function addStone($amount) {
        $this->stone += $amount;
    }
    
    /**
     * @param integer $amount
     */
    public function addOre($amount) {
        $this->ore += $amount;
    }
 
    /**
     * @param integer $amount
     */
    public function addRuby($amount) {
        $this->ruby += $amount;
    }
    
    /**
     * @param integer $amount
     */
    public function addGrain($amount) {
        $this->grain += $amount;
    }
    
    /**
     * @param integer $amount
     */
    public function addVegetable($amount) {
        $this->grain += $amount;
    }    
    
    /**
     * @param integer $amount
     */
    public function addVp($amount) {
        $this->vp += $amount;
    }
    
    /**
     * Add dwarf
     *
     * @param \Caverna\CoreBundle\Entity\Dwarf $dwarf
     *
     * @return Player
     */
    public function addDwarf(\Caverna\CoreBundle\Entity\Dwarf $dwarf)
    {
        $dwarf->setPlayer($this);
        $this->dwarfs[] = $dwarf;
        $dwarf->setNum($this->getDwarfs()->count());

        return $this;
    }
    
    /**
     * Get dwarfs
     *
     * @return \Doctrine\Common\Collections\Collection
     */    
    public function getAvailableDwarfs() {
        $availableDwarfs = new ArrayCollection();
        foreach ($this->dwarfs as $dwarf) {
            if ($dwarf->isAvailable()) {
                $availableDwarfs[] = $dwarf;
            }
        }
        return $availableDwarfs;
    }
    
    /**
     * Add forestSpace
     *
     * @param \Caverna\CoreBundle\Entity\ForestSpace\BaseForestSpace $forestSpace
     *
     * @return Player
     */
    public function addForestSpace(\Caverna\CoreBundle\Entity\ForestSpace\BaseForestSpace $forestSpace)
    {
        $this->forestSpaces[] = $forestSpace;
        $forestSpace->setPlayer($this);

        return $this;
    }

    /**
     * Add caveSpace
     *
     * @param \Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace $caveSpace
     *
     * @return Player
     */
    public function addCaveSpace(\Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace $caveSpace)
    {
        $this->caveSpaces[] = $caveSpace;
        $caveSpace->setPlayer($this);

        return $this;
    }

    /**
     * Remove caveSpace
     *
     * @param \Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace $caveSpace
     */
    public function removeCaveSpace(\Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace $caveSpace)
    {
        $caveSpace->setPlayer(null);
        $this->getCaveSpaces()->removeElement($caveSpace);
    }
    
    public function getCaveSpaceByRowCol($row, $col) {
        foreach ($this->getCaveSpaces() as $caveSpace) {
            if ($caveSpace->getRow() === $row && $caveSpace->getCol() === $col) {
                return $caveSpace;
            }
        }
        return null;
    }
    
    public function placeCaveSpace(\Caverna\CoreBundle\Entity\CaveSpace\BaseCaveSpace $caveSpace) {
        $oldCaveSpace = $this->getCaveSpaceByRowCol($caveSpace->getRow(), $caveSpace->getCol());
        $this->removeCaveSpace($oldCaveSpace);
        var_dump($this->getCaveSpaces()->count());
        $this->addCaveSpace($caveSpace);
        var_dump($this->getCaveSpaces()->count());
    }
    
    public function __toString() {
        return $this->num . ' ' . $this->color . ' (#'. $this->id .')';
    }
    
    public function spaceForDwarfs() {
        $spaceForDwarfs = 0;
        foreach ($this->caveSpaces as $caveSpace) {
            if ($caveSpace instanceof SpaceForDwarfsInterface) {
                $spaceForDwarfs += $caveSpace->spaceForDwarfs();
            }
        }
        return $spaceForDwarfs;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dwarfs = new ArrayCollection();
//        $this->addDwarf(new Dwarf());
//        $this->addDwarf(new Dwarf());

        $this->food = 0;
        $this->wood = 0;
        $this->stone = 0;
        $this->ore = 0;
        $this->ruby = 0;
        $this->vp = 0;
        $this->vegetable = 0;
        $this->grain = 0;
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
     * Set color
     *
     * @param string $color
     *
     * @return Player
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set num
     *
     * @param integer $num
     *
     * @return Player
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
     * Set wood
     *
     * @param integer $wood
     *
     * @return Player
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

    /**
     * Set stone
     *
     * @param integer $stone
     *
     * @return Player
     */
    public function setStone($stone)
    {
        $this->stone = $stone;

        return $this;
    }

    /**
     * Get stone
     *
     * @return integer
     */
    public function getStone()
    {
        return $this->stone;
    }

    /**
     * Set food
     *
     * @param integer $food
     *
     * @return Player
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
     * Set ore
     *
     * @param integer $ore
     *
     * @return Player
     */
    public function setOre($ore)
    {
        $this->ore = $ore;

        return $this;
    }

    /**
     * Get ore
     *
     * @return integer
     */
    public function getOre()
    {
        return $this->ore;
    }

    /**
     * Set ruby
     *
     * @param integer $ruby
     *
     * @return Player
     */
    public function setRuby($ruby)
    {
        $this->ruby = $ruby;

        return $this;
    }

    /**
     * Get ruby
     *
     * @return integer
     */
    public function getRuby()
    {
        return $this->ruby;
    }

    /**
     * Set game
     *
     * @param \Caverna\CoreBundle\Entity\Game $game
     *
     * @return Player
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
     * Remove dwarf
     *
     * @param \Caverna\CoreBundle\Entity\Dwarf $dwarf
     */
    public function removeDwarf(\Caverna\CoreBundle\Entity\Dwarf $dwarf)
    {
        $this->dwarfs->removeElement($dwarf);
    }

    /**
     * Get dwarfs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDwarfs()
    {
        return $this->dwarfs;
    }

    /**
     * Set next
     *
     * @param \Caverna\CoreBundle\Entity\Player $next
     *
     * @return Player
     */
    public function setNext(\Caverna\CoreBundle\Entity\Player $next = null)
    {
        $this->next = $next;

        return $this;
    }

    /**
     * Get next
     *
     * @return \Caverna\CoreBundle\Entity\Player
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * Remove forestSpace
     *
     * @param \Caverna\CoreBundle\Entity\ForestSpace\BaseForestSpace $forestSpace
     */
    public function removeForestSpace(\Caverna\CoreBundle\Entity\ForestSpace\BaseForestSpace $forestSpace)
    {
        $this->forestSpaces->removeElement($forestSpace);
    }

    /**
     * Get forestSpaces
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getForestSpaces()
    {
        return $this->forestSpaces;
    }

    /**
     * Set vp
     *
     * @param integer $vp
     *
     * @return Player
     */
    public function setVp($vp)
    {
        $this->vp = $vp;

        return $this;
    }

    /**
     * Get vp
     *
     * @return integer
     */
    public function getVp()
    {
        return $this->vp;
    }

    /**
     * Set grain
     *
     * @param integer $grain
     *
     * @return Player
     */
    public function setGrain($grain)
    {
        $this->grain = $grain;

        return $this;
    }

    /**
     * Get grain
     *
     * @return integer
     */
    public function getGrain()
    {
        return $this->grain;
    }

    /**
     * Set vegetable
     *
     * @param integer $vegetable
     *
     * @return Player
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

    /**
     * Get caveSpaces
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCaveSpaces()
    {
        return $this->caveSpaces;
    }
}
