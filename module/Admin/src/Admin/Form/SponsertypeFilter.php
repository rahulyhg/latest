<?php
namespace Admin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class SponsertypeFilter extends InputFilter {

    public function __construct() {
        	
		

        $this->add(array(
            'name' => 'spons_type_title',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'is_active',
            'required'=> true,
        ));

    }

}
