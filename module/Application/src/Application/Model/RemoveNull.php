<?php

namespace Application\Model;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class RemoveNull implements StrategyInterface{
    public function extract($value) {
       return md5($value);
        
        
    }

    public function hydrate($value) {
        return $value;
    }

}
