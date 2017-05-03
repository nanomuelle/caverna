<?php

namespace AppBundle\Command\GameActionSpace;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Caverna\CoreBundle\GameEngine\GameEngine;
use Caverna\CoreBundle\Entity\ActionSpace\OreMiningActionSpace;

use AppBundle\Command\GameActionSpace\ActionSpaceCommand;

use Caverna\CoreBundle\GameEngine\Action\OreMining;
/**
 * @author marte
 */
class OreMiningCommand extends ActionSpaceCommand {
    public function __construct(GameEngine $gameEngineService) {
        parent::__construct($gameEngineService);        
        $this->actionSpaceKey = OreMiningActionSpace::KEY;
    }
    
    protected function configure() {
        parent::configure();
        $this                
            ->setName('game:action:ore-mining')
            ->setDescription('Ore Mining')
            ;        
    }    
    
    protected function executeActionSpace(InputInterface $input, OutputInterface $output) {
        OreMining::execute($this->actionSpace, $this->player, $this->options);
    }    
}
