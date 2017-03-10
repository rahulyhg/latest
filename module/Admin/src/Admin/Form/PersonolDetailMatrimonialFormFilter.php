<?php

namespace Admin\Form\Filter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class PersonolDetailMatrimonialFormFilter extends InputFilter {

    public function __construct($sm) {
        // self::__construct(); // parnt::__construct(); - trows and error

        $this->add(array(
            'name' => 'gothra_gothram',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'star_sign',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'zodiac_sign_raasi',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'height',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'body_weight_type',
            'required' => false,
        ));
        
         $this->add(array(
            'name' => 'age',
            'required' => false,
        ));
        
    }

}
