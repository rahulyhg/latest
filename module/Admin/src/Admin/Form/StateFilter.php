<?php
namespace Admin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class StateFilter extends InputFilter {

    public function __construct() {
        	
		$this->add(array(
            'name' => 'country_id',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'state_name',
            'required'=> true,
        ));
        
        $this->add(array(
            'name' => 'state_code',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'is_active',
            'required'=> false,
        ));

    }

}