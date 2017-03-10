<?php

namespace Application\Form\Filter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class SignupMemberFormFilter extends InputFilter {

    public function __construct($sm) {
        // self::__construct(); // parnt::__construct(); - trows and error
        $this->add(array(
            'name' => 'username',
            'required' => true,
        
        ));

        $this->add(array(
            'name' => 'email',
            'required' => true,
          
  
        ));

        $this->add(array(
            'name' => 'password',
            'required' => true,
        ));
        
        
        
                

        
        
    }

}
