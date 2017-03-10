<?php
namespace Admin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class PagesFilter extends InputFilter {

    public function __construct() {
            
        $this->add(array(
            'name' => 'title',
            'required'=> true,
        ));
        
        $this->add(array(
            'name' => 'page_name',
            'required'=> true,
        ));

         $this->add(array(
            'name' => 'description',
            'required'=> true,
        ));

//          $this->add(array(
//             'name' => 'tab_id',
//             'required'=> false,
//         ));
        

        $this->add(array(
            'name' => 'is_active',
            'required'=> true,
        ));

    }

}
