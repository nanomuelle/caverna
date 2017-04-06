<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\ImitationActionSpace;

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
        
        $imitableActionSpaceKeys = [];
        $inversedActionSpaces = [];
        
        $imitableActionSpaces = $this->game->getImitableActionSpacesForPlayer($this->player);
        foreach($imitableActionSpaces as $actionSpace) {
            $imitableActionSpaceKeys[] = $actionSpace->getDwarf();
            $inversedActionSpaces[''. $actionSpace->getDwarf()] = $actionSpace;
        }
        $question = new ChoiceQuestion('Selecciona actionSpace que quieres imitar:', $imitableActionSpaceKeys);
        $question->getAutocompleterValues($imitableActionSpaceKeys);
        $question->setErrorMessage('El actionSpace %s no es valido.');
        $selectedActionSpace = $helper->ask($input, $output, $question);
        
        return $inversedActionSpaces[$selectedActionSpace];
    }    
    
    protected function interact(InputInterface $input, OutputInterface $output) {
        parent::interact($input, $output);
        
        $imitatedActionSpace = $this->selectActionSpace($input, $output);
        $this->actionSpace->setActionSpace($imitatedActionSpace);
    }
}
