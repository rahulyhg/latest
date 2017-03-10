<?php

namespace Common\Form\Fieldset;

use Common\Form\Entity\Credentials\Credentials;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class CredentialsFieldset extends Fieldset {

      public function __construct()
     {
         parent::__construct('credentials');
         $this->setHydrator(new ClassMethodsHydrator(false));
           $this->setObject(new Credentials());
   

        $this->add(array(
            'type' => 'text',
            'name' => 'title',
            'options' => array(
                'label' => 'Title'
            )
        ));

//        $this->add(array(
//            'type' => 'text',
//            'name' => 'password',
//            'options' => array(
//                'label' => 'Password'
//            )
//        ));
    }

}
