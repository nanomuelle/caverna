<?php

namespace Caverna\CoreBundle\GameEngine;

use Doctrine\ORM\EntityManager;

use Caverna\CoreBundle\GameEngine\FourPlayersGameBuilder;

use Caverna\CoreBundle\Entity\Game;
use Caverna\CoreBundle\Entity\Player;
//use Caverna\CoreBundle\Entity\Round;
use Caverna\CoreBundle\Entity\Turn;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * Description of GameEngine
 *
 * @author marte
 */
class GameEngine {
    protected $em;
    
    public function __toString() {
        return 'GameEngine';
    }
    
    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }
    
    public function newGame($num_jugadores) {       
        if ($num_jugadores == 4) {
            $game = FourPlayersGameBuilder::create();  
            
            foreach ($game->getActionSpaces() as $actionSpace) {
                $this->em->persist($actionSpace);
            }
            
            $this->em->persist($game);
        }
        
        $this->em->flush();
        return $game;
    }
    
    public function gameList() {        
        return $this->em->getRepository(Game::class)
            ->findAll();        
    }
    
    /**
     * 
     * @param integer $id
     * @return Game
     */
    public function game($id) {
        return $this->em->getRepository(Game::class)
                ->find($id);
    }
    
    public function replenish(Game $game) {
        $numRound = $game->getCurrentRound()->getNum();
        foreach ($game->getActionSpaces() as $actionSpace) {
            if ($numRound >= $actionSpace->getAvailableFromRoundNum()) {
                $actionSpace->replenish();
            }
        }
    }
    
    public function startGame(Game $game) {
        if ($game->getStatus() !== Game::STATUS_READY) {
            return;
        }
        
        $this->createTurnsForCurrentRound($game);
        $game->setStatus(Game::STATUS_PLAYING);
        $this->replenish($game);
        
        $this->em->persist($game);
        $this->em->flush();
    }
    
    public function executeActionSpace(ActionSpace $actionSpace) {
        $actionSpace->getGame()->getCurrentRound()->getCurrentTurn()->setActionSpace($actionSpace);
        $this->executeAction($actionSpace);
    }
    
    public function executeAction(ActionSpace $actionSpace) {
        $actionClass = '\\Caverna\\CoreBundle\\GameEngine\\Action\\' . $actionSpace->getKey();
        $actionClass::execute($actionSpace);
        
        $this->em->persist($actionSpace->getGame());
        $this->em->flush();
        $this->em->clear(); // clear em cache        
    }
    
    public function finishCurrentTurn(Game $game) {
        $game->getCurrentRound()->finishCurrentTurn();
        
        $this->em->persist($game);
        $this->em->flush();
    }
    
    /**
     * 
     * @param int $num
     * @param Player $player
     * @return Turn
     */
    private function createTurn($num, Player $player) {
        $turn = new Turn();
        $turn->setNum($num);
        $turn->setPlayer($player);
        return $turn;
    }
    
    private function createTurnsForCurrentRound(Game $game) {
        $enanos = array();
        $players = $game->getPlayers();        
        $round = $game->getCurrentRound();        
        $enanos_restantes = 0;
        
        foreach($players as $player) {
            $enanos[$player->getId()] = $player->getDwarfs()->count();
            $enanos_restantes += $player->getDwarfs()->count();
        }
        
        $player = $round->getInitialPlayer();
        $contador_turnos = 1;
        while ($enanos_restantes > 0) {
            if ($enanos[$player->getId()] > 0) {
                $round->addTurn($this->createTurn($contador_turnos, $player));                        
                
                $this->em->persist($round);
                        
                $enanos[$player->getId()]--;
                $contador_turnos++;
                $enanos_restantes--;
            }
            $player = $player->getNext();
        }
        
        $this->em->persist($round);
        $this->em->flush();
    }
    
    public function finishCurrentRound(Game $game) {
        $nextRound = $game->getNextRound();
        
        if ($nextRound !== null) {
            $game->setCurrentRound($nextRound);
            $this->createTurnsForCurrentRound($game);
            
            foreach ($game->getActionSpaces() as $actionSpace) {
                $dwarf = $actionSpace->getDwarf();
                if ($dwarf !== null) {
                    $dwarf->setActionSpace(null);
                    $actionSpace->setDwarf(null);
                    
                    $this->em->persist($dwarf);
                    $this->em->persist($actionSpace);
                }                
            }

            // TODO: HARVEST
            // $this->harvest($game);
            
            $this->replenish($game);
            
            $this->em->persist($game);
            $this->em->flush();
            
            return;
        }
        
        // TODO: FIN DE LA PARTIDA
    }    
}
