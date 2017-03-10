<?php

namespace Common\Form\Fieldset;

use Common\Form\Entity\User\User;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class UserFieldset extends Fieldset {

    public function __construct()
     {
         parent::__construct('user-fieldset');
          $this
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new User())
         ;


        $this->add(array(
            'type' => 'Common\Form\Fieldset\ProfileFieldset',
            'name' => 'profile'
        ));

        $this->add(array(
            'type' => 'Common\Form\Fieldset\CredentialsFieldset',
            'name' => 'credentials'
        ));
        
        $this->add(array(
            'type' => 'hidden',
            'name' => 'id'
        ));
    }

}
