<?php

namespace Application\Form\Filter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class SignupFormFilter extends InputFilter {

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
        
        $this->add(array(
            'name' => 'dob',
            'required' => true,
        ));                
        
        $this->add(array(
            'name' => 'gender',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'country',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'state',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'city',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'rustagi_branch',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'profession',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'gothra_gothram',
            'required' => false,
        ));
        
                

        
        
    }

}
