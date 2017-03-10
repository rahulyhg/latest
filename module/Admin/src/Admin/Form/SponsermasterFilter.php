<?php
namespace Admin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class SponsermasterFilter extends InputFilter {

    public function __construct() {
        	
		

        $this->add(array(
            'name' => 'spons_name',
            'required'=> true,
        ));
        
        $this->add(array(
            'name' => 'spons_poc_name',
            'required'=> true,
        ));
        
        $this->add(array(
            'name' => 'spons_desig',
            'required'=> true,
        ));
        
        $this->add(array(
            'name' => 'spons_phone_no',
            'required'=> true,
        ));
        
        $this->add(array(
            'name' => 'spons_image',
            'required'=> true,
        ));
        
        $this->add(array(
            'name' => 'spons_desc',
            'required'=> true,
        ));
        
        $this->add(array(
            'name' => 'spons_email',
            'required'=> true,
        ));
        
//        $this->add(array(
//            'name' => 'spons_country',
//            'required'=> true,
//        ));
//        
//        $this->add(array(
//            'name' => 'spons_state',
//            'required'=> true,
//        ));
//        
//        $this->add(array(
//            'name' => 'spons_city',
//            'required'=> true,
//        ));
        
        $this->add(array(
            'name' => 'spons_address',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'is_active',
            'required'=> true,
        ));

    }

}
