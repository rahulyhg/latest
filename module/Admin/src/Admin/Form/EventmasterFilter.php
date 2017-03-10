<?php
namespace Admin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class EventmasterFilter extends InputFilter {

    public function __construct() {
        	
		

        $this->add(array(
            'name' => 'event_name',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'is_active',
            'required'=> true,
        ));

    }

}
