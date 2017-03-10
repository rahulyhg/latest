<?php
namespace Admin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class CityFilter extends InputFilter {

    public function __construct() {
        	
		$this->add(array(
            'name' => 'state_id',
            'required'=> true,
        ));
                
                $this->add(array(
            'name' => 'country_id',
            'required'=> false,
        ));

        $this->add(array(
            'name' => 'city_name',
            'required'=> true,
        ));
        
        $this->add(array(
            'name' => 'city_code',
            'required'=> true,
        ));
        
        $this->add(array(
            'name' => 'image',
            'required'=> false,
        ));

        $this->add(array(
            'name' => 'is_active',
            'required'=> false,
        ));

    }

}
