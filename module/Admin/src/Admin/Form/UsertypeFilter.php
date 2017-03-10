<?php
namespace Admin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class UsertypeFilter extends InputFilter {

    public function __construct() {
        	
        $this->add(array(
            'name' => 'user_type',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'is_active',
            'required'=> true,
        ));

    }

}
