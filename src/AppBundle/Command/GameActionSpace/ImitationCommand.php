<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\ArrayInput;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\ImitationActionSpace;

use AppBundle\Console\SimpleChoiceQuestion;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

/**
 * @author marte
 */
class ImitationCommand extends ActionSpaceCommand {
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = ImitationActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName('game:action:imitation')
            ->setDescription('Imitation')
            ;        
    }    

    protected function selectActionSpace(InputInterface $input, OutputInterface $output) {
        $helper = $this->getHelper('question');
        $imitableActionSpaces = $this->game->getImitableActionSpacesForPlayer($this->player);
        $question = new SimpleChoiceQuestion('Selecciona la accion que quieres imitar:', $imitableActionSpaces);
        return $helper->ask($input, $output, $question);
    }    
    
    protected function interact(InputInterface $input, OutputInterface $output) {
        parent::interact($input, $output);        
        $imitatedActionSpace = $this->selectActionSpace($input, $output);
        $this->actionSpace->setImitatedActionSpace($imitatedActionSpace);
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        $commandToImitate = 'AppBundle\\Command\\GameActionSpace\\' . $this->actionSpace->getImitatedActionSpace()->getKey() . 'Command';

        $command = $this->getApplication()->find($commandToImitate::COMMAND_NAME);
        $command->run(new ArrayInput(array(
            'command' => $commandToImitate::COMMAND_NAME,
            'id' => $this->game->getId(),
            'imitation' => true
        )), $output);        

        parent::execute($input, $output);
    }    
}
