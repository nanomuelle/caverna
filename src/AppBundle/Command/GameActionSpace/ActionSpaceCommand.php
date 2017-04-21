<?php

namespace AppBundle\Command\GameActionSpace;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use AppBundle\Command\GameCommandBase;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\Game;
use Caverna\CoreBundle\Entity\Player;
use Caverna\CoreBundle\Entity\Dwarf;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;
use Caverna\CoreBundle\Entity\ActionSpace\ImitationActionSpace;

use AppBundle\Console\SimpleChoiceQuestion;

/**
 * @author marte
 */
class ActionSpaceCommand extends GameCommandBase {
    /**
     * @var Game
     */
    protected $game;
    
    /**
     * @var Player
     */
    protected $player;
    
    /**
     * @var Dwarf
     */
    protected $dwarf;
    
    /**
     * @var ActionSpace
     */
    protected $actionSpace;
    
    /**
     * @var string
     */
    protected $actionSpaceKey;
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);
        $this->actionSpaceKey = '';
    }

    protected function configure() {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'Game Id')
            ->addArgument('imitation', InputArgument::OPTIONAL, 'Ejecutar como imitacion', false)
            ;
    }    

    private function validateActionSpace($is_imitation) {
        if ($this->actionSpaceKey === '') {
            throw new Exception('$actionSpaceKey debe ser definido en el metodo __construnct de la subclase.');
        }
        
        $actionSpace = $this->game->getActionSpaceByKey($this->actionSpaceKey);
        
        if ($actionSpace === null) {
            throw new \Exception($this->actionSpaceKey . ' no esta disponible.');
        }
        
        if ($is_imitation && $actionSpace->getDwarf() === null) {
            throw new \Exception($actionSpace->getKey() . ' no esta acupado, no se puede imitar.');
        }
        
        if (!$is_imitation && $actionSpace->getKey() !== ImitationActionSpace::KEY && $actionSpace->getDwarf() !== null) {
            throw new \Exception($actionSpace->getKey() . ' esta acupado por: ' . $actionSpace->getDwarf());
        }

        $this->actionSpace = $actionSpace;
    }
    
    private function unoBasedArray($array) {
        $index = 1;
        $outputArray = array();
        foreach ($array as $value) {
            $outputArray[''. $index] = $value;
            $index++;
        }
        return $outputArray;
    }
    
    protected function selectDwarf(InputInterface $input, OutputInterface $output) {
        $helper = $this->getHelper('question');
        $question = new SimpleChoiceQuestion('Selecciona enano:', $this->player->getAvailableDwarfs());
        return $helper->ask($input, $output, $question);
   
    }
    
    protected function interact(InputInterface $input, OutputInterface $output) {
        $this->game = $this->gameEngineService->game($input->getArgument('id'));
        $this->player = $this->game->getCurrentRound()->getCurrentTurn()->getPlayer();
        
        $is_imitation = $input->getArgument('imitation');
        $this->validateActionSpace($is_imitation);
        
        if (!$is_imitation) {
            $this->dwarf = $this->selectDwarf($input, $output);
        }
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        if ( $input->getArgument('imitation') ) {
            return;
        } 

        $this->actionSpace->setDwarf($this->dwarf);
        $this->gameEngineService->executeActionSpace($this->actionSpace);
        
        $showCommand = $this->getApplication()->find('game:show');
        $showCommand->run(new ArrayInput(array(
            'command' => 'game:show',
            'id' => $this->game->getId()
        )), $output);
    } 
}
