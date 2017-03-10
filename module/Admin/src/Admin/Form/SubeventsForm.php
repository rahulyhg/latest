<?php

namespace Admin\Form;

use Admin\Model\Entity\Subevents;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class SubeventsForm extends Form {

//    public static $country_nameList = array();
//    public static $city_nameList = array();
//    public static $state_nameList = array();
    public static $spons_masterList = array();
    public static $spons_typeList = array();
    public static $organiser_List = array();
    public static $event_nameList = array();

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('Subevents');
        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        $this->setObject(new Subevents());

        $this->add(array(
            'name' => 'subevent_id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'title'
            ),
            'options' => array(
                'label' => 'Subevent Title',
            ),
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
            'name' => 'event_id',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'event_id'
            ),
            'options' => array(
                'label' => 'Events',
                'empty_option' => '--Please Select--',
                'value_options' => self::$event_nameList,
            )
        ));




        $this->add(array(
            'name' => 'venue',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'form-control',
                'id' => 'venue'
            ),
            'options' => array(
                'label' => 'venue',
            ),
        ));

        $this->add(array(
            'name' => 'start_date',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'start_date',
                
            ),
            'options' => array(
                'label' => 'Start Date',
            ),
        ));

        $this->add(array(
            'name' => 'end_date',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'end_date'
            ),
            'options' => array(
                'label' => 'End Date',
            ),
        ));

        $this->add(array(
            'name' => 'start_time',
            'attributes' => array(
                'type' => 'time',
                'class' => 'form-control timepicker',
                'id' => 'start_time'
            ),
            'options' => array(
                'label' => 'Start Time',
            ),
        ));

        $this->add(array(
            'name' => 'end_time',
            'attributes' => array(
                'type' => 'time',
                'class' => 'form-control timepicker',
                'id' => 'end_time'
            ),
            'options' => array(
                'label' => 'End Time',
            ),
        ));


        $this->add(array(
            'name' => 'fees',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'fees'
            ),
            'options' => array(
                'label' => 'Fees',
            ),
        ));


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
