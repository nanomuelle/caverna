<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Console\SimpleChoiceQuestion;
use Symfony\Component\Console\Question\ChoiceQuestion;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\GameEngine\Action\Growth;
use Caverna\CoreBundle\Entity\ActionSpace\GrowthActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

/**
 * @author marte
 */
class GrowthCommand extends ActionSpaceCommand {
    const COMMAND_NAME = 'game:action:growth';
    
    private $choices;
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = GrowthActionSpace::KEY;
        $this->choices = array (
            1 => 'Recoger recursos', 
            2 => 'Crecer familia'
        );
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName(self::COMMAND_NAME)
            ->setDescription('Growth')
            ;
    }
    
    protected function interact(InputInterface $input, OutputInterface $output) {
        parent::interact($input, $output);
        
        $helper = $this->getHelper('question');
//        $question = new SimpleChoiceQuestion('Selecciona que quieres hacer:', $this->choices);
        $question = new ChoiceQuestion('Selecciona que quieres hacer:', $this->choices);
        $this->options['action'] = $helper->ask($input, $output, $question);
    }
    
    protected function executeActionSpace(InputInterface $input, OutputInterface $output) {
        var_dump($this->options);
        if ($this->options['action'] === $this->choices[1]) {
            Growth::takeResources($this->actionSpace, $this->player);
        }
    }    
}
