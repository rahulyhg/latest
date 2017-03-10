<?php

namespace Application\Form;

use Application\Model\Entity\UserInfo;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class AboutFormMatrimonial extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('form');
        $this->setAttribute('method', 'post');
         $this->setHydrator(new ClassMethods(true));
        //$this->setObject(new UserInfo());

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

   

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'about_me',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'about_me'
            )
       
        ));



        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Submit',
                'id' => 'submit',
                'class' => 'btn btn-default'
            ),
        ));
    }

}

?>