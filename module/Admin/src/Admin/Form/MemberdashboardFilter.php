<?php
namespace Admin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class MemberdashboardFilter extends InputFilter {

    public function __construct() {
        	
		

        $this->add(array(
            'name' => 'full_name',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'is_active',
            'required'=> true,
        ));

    }

}
