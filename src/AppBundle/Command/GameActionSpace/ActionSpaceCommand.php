<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use Symfony\Component\Console\Question\ChoiceQuestion;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\Game;
use Caverna\CoreBundle\Entity\Player;
use Caverna\CoreBundle\Entity\Dwarf;
use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

/**
 * @author marte
 */
class ActionSpaceCommand extends Command {
    /**
     *
     * @var GameEngine
     */
    protected $gameEngineService;
    
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
     *
     * @var ActionSpace
     */
    protected $actionSpace;
    
    /**
     *
     * @var string
     */
    protected $actionSpaceKey;
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct();
        $this->actionSpaceKey = '';
        $this->gameEngineService = $gameEngineService;
    }

    protected function configure() {
        $this
                ->addArgument('id', InputArgument::REQUIRED, 'Game Id')
                ;
    }    

    private function validateActionSpace() {
        if ($this->actionSpaceKey === '') {
            throw new Exception('$actionSpaceKey debe ser definido en el metodo __construnct de la subclase.');
        }
        
        $actionSpace = $this->game->getActionSpaceByKey($this->actionSpaceKey);
        
        if ($actionSpace === null) {
            throw new \Exception($this->actionSpaceKey . ' no esta disponible.');
        }
        if ($actionSpace->getDwarf() !== null) {
            throw new \Exception($actionSpace->getKey() . ' esta acupado por: ' . $actionSpace->getDwarf());
        }

        $this->actionSpace = $actionSpace;
    }
    
    protected function selectDwarf(InputInterface $input, OutputInterface $output) {
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Selecciona enano:',
            $this->player->getDwarfs()->toArray());
        $question->setErrorMessage('El enano %s no es valido.');
        $selectedDwarf = $helper->ask($input, $output, $question);
        
        foreach ($this->player->getAvailableDwarfs() as $dwarf) {
            if ('' . $dwarf === $selectedDwarf) {
                return $dwarf;
            }
        }
//        $output->writeln('You have just selected: '.$dwarf);                    
    }
    
    protected function interact(InputInterface $input, OutputInterface $output) {
        $this->game = $this->gameEngineService->game($input->getArgument('id'));
        $this->player = $this->game->getCurrentRound()->getCurrentTurn()->getPlayer();
        
        $this->validateActionSpace();
        
        $this->dwarf = $this->selectDwarf($input, $output);                    
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->actionSpace->setDwarf($this->dwarf);
        $this->gameEngineService->executeActionSpace($this->actionSpace);
        
        $showCommand = $this->getApplication()->find('game:show');
        $showCommand->run(new ArrayInput(array(
            'command' => 'game:show',
            'id' => $this->game->getId()
        )), $output);
    } 
}
