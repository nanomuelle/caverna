<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Input\ArrayInput;

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
        $this->actionSpace->setImitatedActionSpace($imitatedActionSpace);
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        // parent::execute($input, $output);
//        var_dump($this->actionSpace->getImitatedActionSpace()->getKey());
        
//        $reflection = new \ReflectionClass($this->actionSpace->getImitatedActionSpace());
        $commandToImitate = 'AppBundle\\Command\\GameActionSpace\\' . $this->actionSpace->getImitatedActionSpace()->getKey() . 'Command';
        $output->writeln('CAVERN SPACE BEFORE COMMAND');
        var_dump($this->actionSpace->getImitatedActionSpace()->getCavernCaveSpace());
        $command = $this->getApplication()->find($commandToImitate::COMMAND_NAME);
        $command->run(new ArrayInput(array(
            'command' => $commandToImitate::COMMAND_NAME,
            'id' => $this->game->getId(),
            'imitation' => true
        )), $output);        
        $output->writeln('CAVERN SPACE AFTER IMITATED COMMAND');
        var_dump($this->actionSpace->getImitatedActionSpace()->getCavernCaveSpace());
        parent::execute($input, $output);
        $output->writeln('CAVERN SPACE AFTER EXECUTE');
        var_dump($this->actionSpace->getImitatedActionSpace()->getCavernCaveSpace());
//        var_dump($actionSpaceCommandToImitate::COMMAND_NAME);        
//        return;
//        $this->actionSpace->setDwarf($this->dwarf);
//        $this->gameEngineService->executeActionSpace($this->actionSpace);
//        
//        $showCommand = $this->getApplication()->find('game:show');
//        $showCommand->run(new ArrayInput(array(
//            'command' => 'game:show',
//            'id' => $this->game->getId()
//        )), $output);        
    }    
}
