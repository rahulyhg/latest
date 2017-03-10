<?php
namespace Admin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class EducationlevelFilter extends InputFilter {

    public function __construct() {
        	
        $this->add(array(
            'name' => 'education_level',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'is_active',
            'required'=> true,
        ));

    }

}
