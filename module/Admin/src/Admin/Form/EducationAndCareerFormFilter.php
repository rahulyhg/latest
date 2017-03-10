<?php

namespace Admin\Form\Filter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class EducationAndCareerFormFilter extends InputFilter {

    public function __construct() {
        // self::__construct(); // parnt::__construct(); - trows and error
        $this->add(array(
            'name' => 'education_level',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'education_field',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'education_field',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'working_with',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'designation',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'specialize_profession',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'annual_income',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'profession',
            'required' => false,
        ));     
        
        $this->add(array(
            'name' => 'office_country',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'office_state',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'office_city',
            'required' => false,
        ));

//        $this->add(array(
//            'name' => 'specialize_profession',
//            'required' => true,
//            'filters' => array(
//                array('name' => 'StripTags'),
//                array('name' => 'StringTrim'),
//            ),
//            'validators' => array(
//                array(
//                    'name' => 'StringLength',
//                    'options' => array(
//                        'encoding' => 'UTF-8',
//                        'min' => 1,
//                        'max' => 10,
//                    ),
//                ),
////                array(
////                    'name' => 'not_empty',
////                ),
//            ),
//        ));
        
    }

}
