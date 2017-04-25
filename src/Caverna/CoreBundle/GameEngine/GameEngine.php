<?php

namespace Caverna\CoreBundle\GameEngine;

use Doctrine\ORM\EntityManager;

use Caverna\CoreBundle\GameEngine\FourPlayersGameBuilder;

use Caverna\CoreBundle\Entity\Game;
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
    
    private function replenishActionSpace(ActionSpace $actionSpace) {
        $numRound = $actionSpace->getGame()->getCurrentRound()->getNum();
        
        if ($numRound >= $actionSpace->getAvailableFromRoundNum()) {
            $actionClass = '\\Caverna\\CoreBundle\\GameEngine\\Action\\' . $actionSpace->getKey();
            $actionClass::replenish($actionSpace);            
        }
    }
    
    public function replenish(Game $game) {
        foreach ($game->getActionSpaces() as $actionSpace) {
            $this->replenishActionSpace($actionSpace);
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
    
    private function calcularAccionesRestantes($enanos) {
        
        $acciones_restantes = 0;
        foreach ($enanos as $num_enanos_player) {
            $acciones_restantes += $num_enanos_player;
        }
        return $acciones_restantes;
    }
    
    private function createTurnsForCurrentRound(Game $game) {
        $enanos = array();
        $players = $game->getPlayers();        
        $round = $game->getCurrentRound();
        
        foreach($players as $player) {
            $enanos[$player->getId()] = $player->getDwarfs()->count();
        }
        
        $player = $round->getInitialPlayer();
        $contador_turnos = 1;
        do {
            if ($enanos[$player->getId()] > 0) {
                $turn = new Turn();
                $turn->setNum($contador_turnos);
                $turn->setPlayer($player);
                $round->addTurn($turn);                        
                
                $this->em->persist($round);
                        
                $enanos[$player->getId()]--;
                $contador_turnos++;
            }
            $player = $player->getNext();
            $acciones_restantes = $this->calcularAccionesRestantes($enanos);
        } while($acciones_restantes > 0);
        
        $this->em->persist($round);
        $this->em->flush();
    }
    
}
