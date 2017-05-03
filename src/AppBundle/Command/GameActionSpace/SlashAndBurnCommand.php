<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\SlashAndBurnActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;
use Caverna\CoreBundle\GameEngine\Action\SlashAndBurn;

/**
 * @author marte
 */
class SlashAndBurnCommand extends ActionSpaceCommand
{
    const COMMAND_NAME = 'game:action:slash-and-burn';
    
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = SlashAndBurnActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName(self::COMMAND_NAME)
            ->setDescription('Slash and burn')
            ;
    }        

    protected function interact(InputInterface $input, OutputInterface $output) {
        parent::interact($input, $output);
                
        $helper = $this->getHelper('question');
        $sowableActionSpaces = $this->game->getImitableActionSpacesForPlayer($this->player);
        $question = new SimpleChoiceQuestion('Selecciona la accion que quieres imitar:', $imitableActionSpaces);
        return $helper->ask($input, $output, $question);
        
    }    
    
    protected function executeActionSpace(InputInterface $input, OutputInterface $output) {
        SlashAndBurn::execute($this->actionSpace, $this->player, $this->options);
    }    
}
