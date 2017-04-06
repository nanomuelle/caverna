<?php

namespace Caverna\CoreBundle\GameEngine\Action;

use Caverna\CoreBundle\Entity\ActionSpace\ActionSpace;

abstract class SpaceAction {
    /**
     * @var ActionSpace
     */
    protected $actionSpace;
    
    public function __construct(ActionSpace $actionSpace) {
        $this->actionSpace = $actionSpace;
    }
    
    public abstract function execute();
    public abstract function replenish();
}