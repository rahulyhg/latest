<?php
namespace Admin\Form;

use Admin\Model\Entity\Usertypemasters;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class UsertypemasterForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('Usertypemasters');
        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethods());
        $this->setObject(new Usertypemasters());
        	
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'user_type',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'user_type'
            ),
            'options' => array(
                'label' => 'Usertypemaster Name',
            ),
        ));

        $this->add(array(
        'type' => 'Zend\Form\Element\Select',
        'name' => 'is_active',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'is_active'
        ),
        'options' => array(
            'label' => 'Status',
        'value_options' =>  array(
            '1'=>'Active',
            '0'=>'In Active'),
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
