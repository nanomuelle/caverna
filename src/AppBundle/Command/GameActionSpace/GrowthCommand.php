<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Question\ChoiceQuestion;

use AppBundle\Console\SimpleChoiceQuestion;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\GameEngine\Action\Growth;
use Caverna\CoreBundle\Entity\ActionSpace\GrowthActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

/**
 * @author marte
 */
class GrowthCommand extends ActionSpaceCommand {
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = GrowthActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName('game:action:growth')
            ->setDescription('Growth')
            ;        
    }
    
    protected function interact(InputInterface $input, OutputInterface $output) {
        parent::interact($input, $output);
        
        $choices = array (
            Growth::TAKE_RESOURCES => 'Recoger recursos',
            Growth::FAMILY_GROWTH => 'Crecer familia'            
        );
        $helper = $this->getHelper('question');        
        $question = new ChoiceQuestion('Selecciona que quieres hacer:', $choices);
//        $question = new SimpleChoiceQuestion('Selecciona que quieres hacer:', $choices);
        $this->options = $helper->ask($input, $output, $question);        
    }
    
    protected function executeActionSpace(InputInterface $input, OutputInterface $output) {
        var_dump($this->options);
        return;
        Growth::execute($this->actionSpace, $this->player, $this->options);
    }    
}
