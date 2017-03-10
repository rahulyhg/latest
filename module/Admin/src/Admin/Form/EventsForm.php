<?php

namespace Admin\Form;

use Admin\Model\Entity\Events;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class EventsForm extends Form {

    public static $country_nameList = array();
    public static $city_nameList = array();
    public static $state_nameList = array();
    public static $spons_masterList = array();
    public static $spons_typeList = array();
    public static $organiser_List = array();
    public static $branchList = array();

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('Events');
        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        $this->setObject(new Events());

        $this->add(array(
            'name' => 'event_id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'event_title',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'event_title'
            ),
            'options' => array(
                'label' => 'Event Title',
            ),
        ));

//        $this->add(array(
//            'name' => 'sponser_name',
//            'attributes' => array(
//                'type' => 'text',
//                'class' => 'form-control',
//                'id'=>'sponser_name'
//            ),
//            'options' => array(
//                'label' => 'Sponser Name',
//            ),
//        ));
//
//         $this->add(array(
//            'name' => 'sponser_contact',
//            'attributes' => array(
//                'type' => 'number',
//                'class' => 'form-control',
//                'id'=>'sponser_contact'
//            ),
//            'options' => array(
//                'label' => 'Sponser Contact',
//            ),
//        ));
//
//        $this->add(array(
//            'name' => 'event_organiser',
//            'attributes' => array(
//                'type' => 'text',
//                'class' => 'form-control',
//                'id'=>'event_organiser'
//            ),
//            'options' => array(
//                'label' => 'Organiser Name',
//            ),
//        ));
//
//        $this->add(array(
//            'name' => 'organiser_contact',
//            'attributes' => array(
//                'type' => 'number',
//                'class' => 'form-control',
//                'id'=>'organiser_contact'
//            ),
//            'options' => array(
//                'label' => 'Organiser Contact',
//            ),
//        ));
//
//
//        $this->add(array(
//            'name' => 'sponser_photo',
//            'attributes' => array(
//                'type' => 'file',
//                'class' => 'thisnot',
//                'id'=>'sponser_photo'
//            ),
//            'options' => array(
//                'label' => 'Sponser Photo',
//            ),
//        ));
//
//        $this->add(array(
//            'name' => 'organiser_photo',
//            'attributes' => array(
//                'type' => 'file',
//               'class' => 'thisnot',
//                'id'=>'organiser_photo'
//            ),
//            'options' => array(
//                'label' => 'Organiser Photo',
//            ),
//        ));

        $this->add(array(
            'type' => 'Hidden',
            'name' => 'event_desc',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'event_desc'
            ),
            'options' => array(
                'label' => 'Event Description',
            )
        ));

        $this->add(array(
            'name' => 'image',
            'attributes' => array(
                'type' => 'file',
                'class' => 'form-control',
                'id' => 'image'
            ),
            'options' => array(
                'label' => 'Upload Event Image',
            ),
        ));


        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'event_country',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'event_country'
            ),
            'options' => array(
                'label' => 'Country Name',
                'empty_option' => 'Please Select Country Name',
                'value_options' => self::$country_nameList,
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'event_state',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'event_state'
            ),
            'options' => array(
                'label' => 'State Name',
                'empty_option' => 'Please Select State Name',
                'value_options' => self::$state_nameList,
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'event_city',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'event_city'
            ),
            'options' => array(
                'label' => 'City Name',
                'empty_option' => 'Please Select City Name',
                'value_options' => self::$city_nameList,
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'event_branch_id',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'event_branch_id'
            ),
            'options' => array(
                'label' => 'Branch Name',
                'empty_option' => 'Please Select Branch Name',
                'value_options' =>  self::$branchList,
                'disable_inarray_validator' => true
            )
        ));

//        $this->add(array(
//            'name' => 'event_branch_other',
//            'attributes' => array(
//                'type' => 'text',
//                'class' => 'form-control',
//                'id'=>'event_branch_other'
//                'placeholder' => 'Please Specify Others'
//            ),
//            
//        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'event_branch_other',
            'attributes' => array(
                'id' => 'event_branch_other',
                'placeholder' => 'Please Specify Others',
            //'style'=>'display:none'
            ),
        ));


        $this->add(array(
            'name' => 'event_venue',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'form-control',
                'id' => 'event_venue'
            ),
            'options' => array(
                'label' => 'venue',
            ),
        ));

        $this->add(array(
            'name' => 'event_date',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'event_date'
            ),
            'options' => array(
                'label' => 'Event Date',
            ),
        ));

//        $this->add(array(
//            'name' => 'end_date',
//            'attributes' => array(
//                'type' => 'text',
//                'class' => 'form-control',
//                'id'=>'end_date'
//            ),
//            'options' => array(
//                'label' => 'End Date',
//            ),
//        ));

        $this->add(array(
            'name' => 'event_start_time',
            'attributes' => array(
                'type' => 'time',
                'class' => 'form-control timepicker',
                'id' => 'event_start_time'
            ),
            'options' => array(
                'label' => 'Start Time',
            ),
        ));

        $this->add(array(
            'name' => 'event_end_time',
            'attributes' => array(
                'type' => 'time',
                'class' => 'form-control timepicker',
                'id' => 'event_end_time'
            ),
            'options' => array(
                'label' => 'End Time',
            ),
        ));


//        $this->add(array(
//            'name' => 'event_cost',
//            'attributes' => array(
//                'type' => 'number',
//                'class' => 'form-control',
//                'id'=>'event_cost'
//            ),
//            'options' => array(
//                'label' => 'Event Fees',
//            ),
//        ));
//        $this->add(array(
//            'name' => 'event_members',
//            'attributes' => array(
//                'type' => 'number',
//                'class' => 'form-control',
//                'id'=>'event_members'
//            ),
//            'options' => array(
//                'label' => 'Event Members',
//            ),
//        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'is_active',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'is_active'
            ),
            'options' => array(
                'label' => 'Status',
                'empty_option' => 'Please Select Status',
                'value_options' => array(
                    '1' => 'Active',
                    '0' => 'In Active'),
            )
        ));

//        $this->add(array(
//        'type' => 'Zend\Form\Element\Select',
//        'name' => 'spons_id',
//        'attributes' => array(
//                'class' => 'form-control',
//                'id'=>'spons_id',
//                
//        ),
//        'options' => array(
//            //'label' => 'City Name',
//        //'empty_option' => 'Please Select Sponser',
//        'value_options' =>  self::$spons_masterList,
//        )
//        ));
//        $this->add(array(
//        'type' => 'Zend\Form\Element\Select',
//        'name' => 'spons_type_id',
//        'attributes' => array(
//                'class' => 'form-control',
//                'id'=>'spons_type_id',
//                'multiple'=>'multiple',
//        ),
//        'options' => array(
//            //'label' => 'City Name',
//        //'empty_option' => 'Select Sponser Type',
//        'value_options' =>  self::$spons_typeList,
//        )
//        ));
//        $this->add(array(
//        'type' => 'Zend\Form\Element\Select',
//        'name' => 'organiser_id',
//        'attributes' => array(
//                'class' => 'form-control',
//                'id'=>'organiser_id',
//                'multiple'=>'multiple',
//        ),
//        'options' => array(
//            //'label' => 'City Name',
//        //'empty_option' => 'Select Organiser',
//        'value_options' =>  self::$organiser_List,
//        )
//        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Contact Us',
                'id' => 'submit',
                'class' => 'btn btn-default'
            ),
        ));
    }

}
