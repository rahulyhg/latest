<?php

namespace Application\Form;

//use Application\Form\Entity\EventParticipationFormEntity;
//use Common\Service\CommonServiceInterface;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class EventparticipationForm extends Form {

    //public static $eventNameList = array();
    public static $checkAlreadyExist = "/user/checkAlreadyExist";
    
    public static $eventList=array();

    //public static $rustagi_branchList=array(); 
    public function __construct($name=null) {
        // we want to ignore the name passed
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'eventParticipationForm');
        $this->setAttribute('class', 'custom_error');
        //$this->commonService = $commonService;
        //self::$eventNameList = $this->commonService->getEventList();
        $this->setHydrator(new ClassMethods(true));
        //$this->setObject(new EventParticipationFormEntity());


        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'event_id',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'event_id',
            ),
            'options' => array(
                'empty_option' => 'Please Select Event',
                'value_options' => self::$eventList,
            )
        ));
        
         $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'subevent_id',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'subevent_id',
                 'multiple' => 'multiple',
            ),
            'options' => array(
                //'empty_option' => 'Please Select Sub-Event',
                //'value_options' => self::$userTypeList,
                'disable_inarray_validator' => true
            )
        ));
        
       

        $this->add(array(
            'name' => 'participant_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'participant_name',
                'placeholder'  => 'Name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'name' => 'participant_dob',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'participant_dob',
                'placeholder'  => 'DD-MM-YY'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'name' => 'participant_father_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'participant_father_name',
                'placeholder'  => 'Father`s Name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'name' => 'participant_grandfather_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'participant_grandfather_name',
                'placeholder'  => 'Grand Father`s Name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'type' => 'textarea',
            'name' => 'participant_address',
            'attributes' => array(
                'id' => 'participant_address',
                'class' => 'form-control',
                'placeholder'  => 'Address'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'name' => 'participant_phone_no',
            'attributes' => array(
                //'type' => 'number',
                'class' => 'form-control error',
                'id' => 'participant_phone_no',
                'placeholder'  => 'Phone No'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
        
        $this->add(array(
            'name' => 'participant_mobile_no',
            'attributes' => array(
                //'type' => 'number',
                'class' => 'form-control error',
                'id' => 'participant_mobile_no',
                'placeholder'  => 'Mobile No'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'name' => 'participant_email',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'participant_email',
                'placeholder'  => 'Email'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Submit',
                'id' => 'submit',
                'class' => 'btn btn-default',
            ),
        ));
        
        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'reset',
                'value' => 'Cancel',
                'id' => 'cancelButton',
                'class' => 'btn btn-primary'
            ),
        ));
    }

}

?>