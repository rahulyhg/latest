<?php

namespace Application\Form\Filter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class Family extends InputFilter {

    public function __construct() {
        // self::__construct(); // parnt::__construct(); - trows and error
        $this->add(array(
            'name' => 'father_name',
            'required' => true,
        ));
         $this->add(array(
            'name' => 'grand_father_status',
            'required' => false,
        ));
          $this->add(array(
            'name' => 'grand_mother_status',
            'required' => false,
        ));
           $this->add(array(
            'name' => 'grand_grand_father_status',
            'required' => false,
        ));
            $this->add(array(
            'name' => 'grand_grand_mother_status',
            'required' => false,
        ));
             $this->add(array(
            'name' => 'spouse_father_status',
            'required' => false,
        ));
              $this->add(array(
            'name' => 'spouse_mother_status',
            'required' => false,
        ));
               $this->add(array(
            'name' => 'grand_father_status',
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
