<?php
namespace Admin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class SubeventsFilter extends InputFilter {

    public function __construct() {
        	
		$this->add(array(
            'name' => 'title',
            'required'=> true,
        ));
//        $this->add(array(
//            'name' => 'sponser_name',
//            'required'=> true,
//        ));
//        $this->add(array(
//            'name' => 'event_organiser',
//            'required'=> true,
//        ));

        $this->add(array(
            'name' => 'fees',
            'required'=> true,
        ));

//        $this->add(array(
//            'name' => 'event_country',
//            'required'=> true,
//        ));
//
//        $this->add(array(
//            'name' => 'event_state',
//            'required'=> true,
//        ));
//
//        $this->add(array(
//            'name' => 'event_city',
//            'required'=> true,
//        ));
//        
//        $this->add(array(
//            'name' => 'event_branch_id',
//            'required'=> true,
//        ));
//        
//        $this->add(array(
//            'name' => 'event_branch_other',
//            'required'=> true,
//        ));

        $this->add(array(
            'name' => 'image',
            'required'=> true,
        ));

//        $this->add(array(
//            'name' => 'start_date',
//            'required'=> true,
//        ));
//
//        $this->add(array(
//            'name' => 'end_date',
//            'required'=> true,
//        ));
        
        $this->add(array(
            'name' => 'start_date',
            'required'=> true,
        ));
        
         $this->add(array(
            'name' => 'end_date',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'start_time',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'end_time',
            'required'=> true,
        ));

//        $this->add(array(
//            'name' => 'event_cost',
//            'required'=> true,
//        ));
//
//        $this->add(array(
//            'name' => 'event_members',
//            'required'=> true,
//        ));
//
//        $this->add(array(
//            'name' => 'sponser_contact',
//            'required'=> true,
//        ));
//
//        $this->add(array(
//            'name' => 'organiser_contact',
//            'required'=> true,
//        ));

        $this->add(array(
            'name' => 'is_active',
            'required'=> true,
        ));

    }

}
