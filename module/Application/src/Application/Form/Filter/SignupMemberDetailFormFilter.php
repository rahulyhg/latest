<?php

namespace Application\Form\Filter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class SignupMemberDetailFormFilter extends InputFilter {

    public function __construct($sm) {
        // self::__construct(); // parnt::__construct(); - trows and error
        $this->add(array(
            'name' => 'caste',
            'required' => true,
        
        ));
        
        $this->add(array(
            'name' => 'cast_other',
            'required' => false,
        
        ));

        $this->add(array(
            'name' => 'full_name',
            'required' => true,
         
        ));
        
        $this->add(array(
            'name' => 'last_name',
            'required' => true,
          
  
        ));

        $this->add(array(
            'name' => 'father_name',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'father_last_name',
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
            'name' => 'native_place',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'profession',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'profession_other',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'rustagi_branch',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'rustagi_branch_other',
            'required' => false,
        ));
        
        
        
        
        
                

        
        
    }

}
