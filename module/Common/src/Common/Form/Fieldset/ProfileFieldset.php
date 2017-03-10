<?php

namespace Common\Form\Fieldset;

use Common\Form\Entity\Profile\Profile;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ProfileFieldset extends Fieldset {

    public function __construct() {
        parent::__construct('profile');
        $this->setHydrator(new ClassMethodsHydrator(false));
        $this->setObject(new Profile);



        $this->add(array(
            'type' => 'text',
            'name' => 'text',
            'options' => array(
                'label' => 'Text'
            )
        ));

//        $this->add(array(
//            'type' => 'text',
//            'name' => 'mobile',
//            'options' => array(
//                'label' => 'Mobile Number'
//            )
//        ));
    }

}
