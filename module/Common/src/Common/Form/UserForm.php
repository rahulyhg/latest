<?php
namespace Common\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class UserForm extends Form {

    public function __construct()
     {
         parent::__construct('user');
        
           $this  ->setHydrator(new ClassMethodsHydrator(false));
           
         

        $this->add(array(
            'name' => 'user-fieldset',
            'type' => 'Common\Form\Fieldset\UserFieldset',
            'options' => array(
                'use_as_base_fieldset' => true
            )
        ));
        

        $this->add(array(
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Insert new Post'
            )
        ));
    }

}
