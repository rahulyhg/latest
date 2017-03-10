<?php
namespace Admin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class ZodiacsignFilter extends InputFilter {

    public function __construct() {
        	
		

        $this->add(array(
            'name' => 'zodiac_sign_name',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'is_active',
            'required'=> true,
        ));

    }

}
