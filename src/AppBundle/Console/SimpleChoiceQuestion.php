<?php

namespace AppBundle\Console;

use Symfony\Component\Console\Question\Question;

class SimpleChoiceQuestion extends Question {
    
    private function oneBasedArray($array) {
        $index = 1;
        $outputArray = array();
        foreach ($array as $value) {
            $outputArray[$index] = $value;
            $index++;
        }
        return $outputArray;
    }
    
    public function __construct($question, $choices) {
        $oneBasedChoices = $this->oneBasedArray($choices);
        
        $info = $question. "\n";
        foreach ($oneBasedChoices as $key => $value) {
            $info .= '  [<fg=green>' . $key . '</>] ' . $value . "\n";
        }
        
        parent::__construct($info . '> ');
        
        $this->setValidator(function ($answer) use ($oneBasedChoices) {
            return $oneBasedChoices[$answer];
        });
    }  
}