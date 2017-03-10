<?php

namespace Registration\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class RegistrationFilter extends InputFilter {

    public function __construct($sm) {
        // self::__construct(); // parnt::__construct(); - trows and error
        $this->add(array(
            'name' => 'username',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Username is required'
                        )
                    )
                ),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100
                    )
                ),
                array(
                    'name' => 'Zend\Validator\Db\NoRecordExists',
                    'options' => array(
                        'table' => 'users',
                        'field' => 'username',
                        'adapter' => $sm->get('Zend\Db\Adapter\Adapter')
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'I am sorry, your email is required'
                        )
                    )
                ),
                array(
                    'name' => 'StringLength',
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => '5',
                        'max' => '250'
                    )
                ),
                array(
                    'name' => 'EmailAddress',
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'messages' => array(
                            // We can even leave a neat little error
                            // message to display
                            'emailAddressInvalidFormat' => 'Your email seems to
be invalid'
                        )
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 6,
                        'max' => 12
                    )
                )
            )
        ));

        /*
         * $this->add(array(
         * 'name' => 'password_confirm',
         * 'required' => true,
         * 'filters' => array(
         * array('name' => 'StripTags'),
         * array('name' => 'StringTrim'),
         * ),
         * 'validators' => array(
         * array(
         * 'name' => 'StringLength',
         * 'options' => array(
         * 'encoding' => 'UTF-8',
         * 'min' => 6,
         * 'max' => 12,
         * ),
         * ),
         * array(
         * 'name' => 'Identical',
         * 'options' => array(
         * 'token' => 'password',
         * ),
         * ),
         * ),
         * ));
         */
    }

}
