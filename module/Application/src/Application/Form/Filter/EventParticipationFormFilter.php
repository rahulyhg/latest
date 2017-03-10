<?php

namespace Application\Form\Filter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\Validator;

class EventParticipationFormFilter extends InputFilter {

    public function __construct($sm) {
        // self::__construct(); // parnt::__construct(); - trows and error
        $this->add(array(
            'name' => 'event_id',
            'required' => true,
        ));

        $this->add(array(
            'name' => 'subevent_id',
            'required' => true,
        ));

        $this->add(array(
            'name' => 'participant_name',
            'required' => true,
        ));

        $this->add(array(
            'name' => 'participant_dob',
            'required' => true,
            'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Zend\Validator\Date',
                         'options' => array(
                                'format' => 'd-m-yy',
                            ),
                    ),                  
            ),
        ));

        $this->add(array(
            'name' => 'participant_father_name',
            'required' => true,
        ));

        $this->add(array(
            'name' => 'participant_grandfather_name',
            'required' => true,
        ));

        $this->add(array(
            'name' => 'participant_address',
            'required' => true,
        ));

        $this->add(array(
            'name' => 'participant_phone_no',
            'required' => true,
            'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Zend\Validator\Digits',
                    ),                  
            ),
        ));

        $this->add(array(
            'name' => 'participant_mobile_no',
            'required' => true,
            'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Zend\Validator\Digits',
                    ),                  
                ),
               
        ));

        $this->add(array(
            'name' => 'participant_email',
            'required' => true,
             'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
                'validators' => array(
                    new Validator\EmailAddress(),
                ),
        ));
    }

}
