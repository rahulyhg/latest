<?php
namespace Admin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class BranchFilter extends InputFilter {

    public function __construct() {
        	
        $this->add(array(
            'name' => 'country',
            'required'=> false,
        ));
        $this->add(array(
            'name' => 'state',
            'required'=> false,
        ));
        $this->add(array(
            'name' => 'branch_city_id',
            'required'=> false,
        ));

        $this->add(array(
            'name' => 'branch_name',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'is_active',
            'required'=> false,
        ));

    }

}
